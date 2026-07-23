<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\MarkPaper;
use App\Models\MarksEntrantAssignment;
use App\Models\SubjectPaper;
use App\Models\House;
use App\Models\MasterData;
use App\Models\ClassAllocation;
use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\StudentBasic;
use App\Models\StudentResult;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\DB;

use setasign\Fpdi\Fpdi;
use Mpdf\Mpdf;

use App\Exports\ExamStatisticsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\SchoolPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ItebController extends Controller
{
    /**
     * The logged-in admin-tab user (regular admin or restricted marks
     * entrant). Null if nobody with an admin session is currently acting
     * (e.g. a real student session hitting these routes).
     */
    private function currentUser()
    {
        $adminId = session('LoggedAdmin');
        return $adminId ? \App\Models\User::find($adminId) : null;
    }

    public function searchItebStudents(Request $request)
    {
        return view('itemGrading.marks');
    }
    public function filter(Request $request)
    {
        $ucePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.UCEPapers')
        )->get();

        $uacePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.UACEPapers')
        )->get();

        $plePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.PLEPapers')
        )->get();

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;

        $records = ClassAllocation::where('Student_ID', 'LIKE', "%$schoolNumber%")
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->select('Student_ID')
            ->distinct()
            ->get();
        // dd($records);
        $studentNames = StudentBasic::whereIn('Student_ID', $records->pluck('Student_ID'))
            ->pluck('Student_Name', 'Student_ID');

        $schoolName = Helper::schoolName($schoolNumber);

        $subjects = ($category == 'UACE') ? $uacePapers : (($category == 'PLE') ? $plePapers : $ucePapers);

        // A school only ever sees: every compulsory subject for the category
        // (auto-registered for the whole class), plus whichever OPTIONAL
        // subjects at least one of its students actually registered for on the
        // Subject Registration screen. Without this, every optional subject in
        // the category showed up for every school, whether or not that school
        // even offers it.
        //
        // registrationMap gives subject_id => Collection of student_ids
        // registered for it, scoped to this batch of students/year — used both
        // to decide which optional subjects belong here and, per subject, which
        // specific students should appear in that subject's marks-entry table
        // (PLE has no optionals, so it's unaffected either way).
        $registrationMap = \App\Models\StudentSubjectRegistration::registrationMap(
            $records->pluck('Student_ID')->all(),
            $year
        );

        if ($category !== 'PLE') {
            $subjects = $subjects->filter(function ($subject) use ($registrationMap) {
                return $subject->md_misc1 === 'Compulsory' || $registrationMap->has($subject->md_id);
            })->values();
        }

        // Per subject: which students to actually list. Compulsory subjects
        // keep showing the whole class (matches how they're auto-registered for
        // everyone); optional subjects only show the students registered for
        // that specific subject, not the entire class.
        $subjectStudentIds = $subjects->mapWithKeys(function ($subject) use ($registrationMap, $records) {
            if ($subject->md_misc1 === 'Compulsory') {
                return [$subject->md_id => $records->pluck('Student_ID')->all()];
            }

            return [$subject->md_id => $registrationMap->get($subject->md_id, collect())->keys()->all()];
        });

        // Annotate each subject with how many papers it has (stored in md_misc3,
        // defaults to 1 for ordinary single-paper subjects), and each paper's
        // maximum raw score (defaults to 100 when not configured otherwise).
        $paperMaxScores = SubjectPaper::whereIn('subject_id', $subjects->pluck('md_id'))
            ->get()
            ->groupBy('subject_id')
            ->map(function ($rows) {
                return $rows->pluck('max_score', 'paper_number');
            });

        // Marks entrants only ever see the subjects/papers assigned to them —
        // everything else is filtered out here, at the source, so the tabs,
        // forms and downstream save logic never even know other subjects exist.
        $currentUser = $this->currentUser();
        $isMarksEntrant = $currentUser && $currentUser->isMarksEntrant();
        $allowedPapersBySubject = $isMarksEntrant
            ? MarksEntrantAssignment::where('user_id', $currentUser->id)
                ->whereIn('subject_id', $subjects->pluck('md_id'))
                ->get()
                ->groupBy('subject_id')
                ->map(fn($rows) => $rows->pluck('paper_number')->all())
            : collect();

        if ($isMarksEntrant) {
            $subjects = $subjects->filter(fn($subject) => $allowedPapersBySubject->has($subject->md_id))->values();
        }

        $subjects = $subjects->map(function ($subject) use ($paperMaxScores, $isMarksEntrant, $allowedPapersBySubject, $subjectStudentIds, $records) {
            $subject->total_papers = (int) ($subject->md_misc3 ?: 1);
            $subject->paper_max_scores = $paperMaxScores[$subject->md_id] ?? collect();
            // null = no restriction (regular admin), array = only these papers
            $subject->allowed_papers = $isMarksEntrant ? ($allowedPapersBySubject[$subject->md_id] ?? []) : null;
            $subject->student_ids = $subjectStudentIds[$subject->md_id] ?? $records->pluck('Student_ID')->all();
            return $subject;
        });

        $existingMarks = [];
        $existingPaperMarks = [];
        if ($subjects->isNotEmpty() && $records->isNotEmpty()) {
            $allMarks = Mark::whereIn('student_id', $records->pluck('Student_ID'))
                ->whereIn('subject_id', $subjects->pluck('md_id'))
                ->get();

            foreach ($allMarks as $mark) {
                $existingMarks[$mark->subject_id][$mark->student_id] = $mark->mark;
            }

            $allPaperMarks = MarkPaper::whereIn('student_id', $records->pluck('Student_ID'))
                ->whereIn('subject_id', $subjects->pluck('md_id'))
                ->get();

            foreach ($allPaperMarks as $paperMark) {
                $existingPaperMarks[$paperMark->subject_id][$paperMark->student_id][$paperMark->paper_number] = $paperMark->raw_mark ?? $paperMark->mark;
            }
        }

        return view('itemGrading.results', compact(
            'records',
            'year',
            'category',
            'schoolNumber',
            'schoolName',
            'subjects',
            'existingMarks',
            'existingPaperMarks',
            'studentNames'
        ));
    }

    public function getMarksForSubject(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'student_ids' => 'required|array',
        ]);

        $currentUser = $this->currentUser();
        if ($currentUser && $currentUser->isMarksEntrant() && empty($currentUser->allowedPapersForSubject($request->subject_id))) {
            return response()->json(['success' => false, 'message' => 'Not assigned to this subject.'], 403);
        }

        $existingMarks = Mark::whereIn('student_id', $request->student_ids)
            ->where('subject_id', $request->subject_id)
            ->pluck('mark', 'student_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'marks' => $existingMarks
        ]);
    }

    public function getSubjectMarks(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'student_ids' => 'required|array',
        ]);

        $currentUser = $this->currentUser();
        if ($currentUser && $currentUser->isMarksEntrant() && empty($currentUser->allowedPapersForSubject($request->subject_id))) {
            return response()->json(['success' => false, 'message' => 'Not assigned to this subject.'], 403);
        }

        $marks = Mark::whereIn('student_id', $request->student_ids)
            ->where('subject_id', $request->subject_id)
            ->pluck('mark', 'student_id');

        return response()->json([
            'success' => true,
            'marks' => $marks
        ]);
    }

    public function enterMarks(Request $request)
    {
        $houses = House::all();

        return view('itemGrading.enterMarks', compact('houses'));
    }

    public function saveMarks(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'marks' => 'required|array',
        ], [
            'subject_id.required' => 'Please select a subject before submitting.',
        ]);

        $subjectId = $request->input('subject_id');
        $marks = $request->input('marks');
        $students = $request->input('students');

        // Marks entrants may only save marks for their assigned subject +
        // papers, even if the request has been tampered with client-side.
        $currentUser = $this->currentUser();
        $allowedPapers = null; // null = no restriction

        if ($currentUser && $currentUser->isMarksEntrant()) {
            $allowedPapers = $currentUser->allowedPapersForSubject($subjectId);

            if (empty($allowedPapers)) {
                return back()->withErrors([
                    'marks' => 'You are not assigned to enter marks for this subject.',
                ])->withInput();
            }
        }

        // Look up this subject's configured max score per paper (defaults
        // to 100 for any paper with no row — an ordinary paper).
        $maxScores = SubjectPaper::where('subject_id', $subjectId)
            ->pluck('max_score', 'paper_number');

        // $marks arrives as either:
        //   marks[STUDENT_ID] = 72                (single-paper subject)
        //   marks[STUDENT_ID][1] = 72, [2] = 65    (multi-paper subject)
        // Normalize everything to the paper-array shape so the rest of
        // this method only has to handle one case.
        $normalized = [];
        foreach ($marks as $studentKey => $value) {
            $normalized[$studentKey] = is_array($value) ? $value : [1 => $value];
        }

        $missing = array_diff($students, array_keys($normalized));
        if (!empty($missing)) {
            return back()->withErrors([
                'marks' => 'Missing marks for students: ' . implode(', ', $missing)
            ])->withInput();
        }

        foreach ($normalized as $studentKey => $paperMarks) {
            $parts = explode('-', $studentKey);
            $year = array_pop($parts);
            $school_number = implode('-', array_slice($parts, 0, 2));
            $category = implode('-', array_slice($parts, 2));

            $convertedPapers = [];
            foreach ($paperMarks as $paperNumber => $rawMark) {
                if ($rawMark === null || $rawMark === '') {
                    continue; // paper left blank — skip, don't count it in the average
                }

                $paperNumber = (int) $paperNumber;

                if ($allowedPapers !== null && !in_array($paperNumber, $allowedPapers)) {
                    continue; // not this entrant's paper to enter — silently ignore
                }

                $maxScore = (float) ($maxScores[$paperNumber] ?? 100);

                if (!is_numeric($rawMark) || $rawMark < 0 || $rawMark > $maxScore) {
                    return back()->withErrors([
                        'marks' => "Invalid mark ({$rawMark}) for student {$studentKey}, paper {$paperNumber}. " .
                            "This paper is marked out of {$maxScore}, so marks must be between 0 and {$maxScore}."
                    ])->withInput();
                }

                // Convert onto a 0-100 scale, e.g. 25 out of 40 -> 62.5
                $convertedMark = round(((float) $rawMark / $maxScore) * 100, 2);
                $convertedPapers[$paperNumber] = $convertedMark;

                MarkPaper::updateOrCreate(
                    [
                        'student_id' => $studentKey,
                        'subject_id' => $subjectId,
                        'paper_number' => $paperNumber,
                    ],
                    [
                        'raw_mark' => $rawMark,
                        'max_score' => $maxScore,
                        'mark' => $convertedMark,
                        'year' => $year,
                        'category' => $category,
                        'school_number' => $school_number,
                    ]
                );
            }

            if (empty($convertedPapers)) {
                return back()->withErrors([
                    'marks' => "No marks entered for student {$studentKey}."
                ])->withInput();
            }

            // Final subject score = average of the CONVERTED (0-100 scale)
            // papers entered so far for this student+subject — this keeps
            // grading/passslips/certificates working unchanged, since they
            // always read a plain 0-100 value from the `marks` table.
            $averageMark = round(array_sum($convertedPapers) / count($convertedPapers), 2);

            Mark::updateOrCreate(
                [
                    'student_id' => $studentKey,
                    'subject_id' => $subjectId,
                ],
                [
                    'mark' => $averageMark,
                    'year' => $year,
                    'category' => $category,
                    'school_number' => $school_number
                ]
            );
        }

        return redirect()->back()->with('success', 'Marks submitted successfully for subject!');
    }

    public function gradingSummary(Request $request)
    {

        $years = StudentBasic::selectRaw('DISTINCT SUBSTRING_INDEX(Student_ID, "-", -1) as year')
            ->whereRaw('Student_ID REGEXP ".*-[0-9]{4}$"')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // $categories = ['UCE' => 'UCE (O-LEVEL)', 'UACE' => 'UACE (A-LEVEL)', 'PLE' => 'Primary (PLE)'];
        $categories = ['UCE' => 'UCE (O-LEVEL)', 'UACE' => 'UACE (A-LEVEL)'];

        
        $schools = ClassAllocation::select('Student_ID')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->Student_ID);
                return implode('-', array_slice($parts, 0, 2));
            })
            ->unique()
            ->filter()
            ->values()
            ->mapWithKeys(function ($item) {
                return [$item => Helper::schoolName($item) ?? $item];
            });


        $totalStudents = ClassAllocation::distinct('Student_ID')->count('Student_ID');
        $gradedSoFar = Mark::distinct('student_id')->count('student_id');
        $pendingGrading = $totalStudents - $gradedSoFar;

        $avgPerformance = Mark::selectRaw('AVG(total_mark) as avg_mark')
            ->fromSub(function ($query) {
                $query->selectRaw('student_id, SUM(mark) as total_mark')
                    ->from('marks')
                    ->groupBy('student_id');
            }, 'student_totals')
            ->value('avg_mark') ?? 0;

        return view('itemGrading.grading-summary', compact(
            'years',
            'categories',
            'schools',
            'totalStudents',
            'gradedSoFar',
            'pendingGrading',
            'avgPerformance',
        ));

    }
    public function processGrading(Request $request)
    {

        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'school_number' => 'nullable',
        ]);

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;
        $level = $request->level ?? ($category === 'UACE' ? 'A' : ($category === 'PLE' ? 'P' : 'O'));

        // Build query for students
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        if ($schoolNumber) {
            $studentsQuery->where('Student_ID', 'LIKE', "$schoolNumber-%");
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);

        // Get total possible marks (each subject out of 100)
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students and subjects
        $marks = Mark::whereIn('student_id', $students)
            ->whereIn('subject_id', $subjectIds)
            ->get()
            ->groupBy('student_id');

        // Calculate results for each student
        $results = [];
        foreach ($students as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            $totalMarks = $studentMarks->sum('mark');
            $subjectsAttempted = $studentMarks->count();

            // Calculate percentage based on total possible marks for category
            $percentage = $totalPossibleMarks > 0
                ? round(($totalMarks / $totalPossibleMarks) * 100, 2)
                : 0;

            // Get grade (D1, D2, C3, C4, F)
            $gradeModel = Grading::getGrade($percentage, 'Marks', $level);

            // Get classification (FIRST CLASS, SECOND CLASS UPPER, etc.)
            $classificationModel = Grading::getGrade($percentage, 'Points', $level);

            // Build marks details with subject names using the helper
            $marksDetails = [];
            foreach ($studentMarks as $mark) {
                $marksDetails[] = [
                    'subject_id' => $mark->subject_id,
                    'mark' => $mark->mark,
                    'subject_name' => Helper::item_md_name($mark->subject_id),
                ];
            }

            $results[$studentId] = [
                'student_id' => $studentId,
                'total_marks' => $totalMarks,
                'total_possible' => $totalPossibleMarks,
                'subjects_attempted' => $subjectsAttempted,
                'total_subjects' => count($subjectIds),
                'percentage' => $percentage,
                'grade' => $gradeModel->Grade ?? 'N/A',
                'grade_comment' => $gradeModel->Comment ?? '',
                'classification' => $classificationModel->Grade ?? 'N/A',
                'classification_comment' => $classificationModel->Comment ?? '',
                'level' => $level,
                'marks_details' => $marksDetails,
            ];
        }

        uasort($results, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $statistics = $this->calculateStatistics($results, $level);

        $schoolName = $schoolNumber ? Helper::schoolName($schoolNumber) : 'All Schools';

        return view('itemGrading.grading-results', compact(
            'results',
            'year',
            'category',
            'schoolNumber',
            'schoolName',
            'statistics',
            'level',
            'totalPossibleMarks'
        ));
    }

    public function saveGradingResults(Request $request)
    {
        $request->validate([
            'results' => 'required|array',
            'year' => 'required',
            'category' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->results as $studentId => $data) {
                StudentResult::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'year' => $request->year,
                        'category' => $request->category,
                    ],
                    [
                        'school_number' => $request->school_number,
                        'total_marks' => $data['total_marks'],
                        'percentage' => $data['percentage'],
                        'grade' => $data['grade'],
                        'classification' => $data['classification'],
                        'level' => $request->level ?? 'A',
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Grading results saved successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error saving results: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getSubjectIdsForCategory($category)
    {
        if ($category == 'UACE') {
            $masterCodeId = config('constants.options.UACEPapers');
        } elseif ($category == 'PLE') {
            $masterCodeId = config('constants.options.PLEPapers');
        } else {
            $masterCodeId = config('constants.options.UCEPapers');
        }

        return MasterData::where('md_master_code_id', $masterCodeId)
            ->pluck('md_id')
            ->toArray();
    }

    private function calculateStatistics($results, $level = 'A')
    {
        $count = count($results);

        if ($count == 0) {
            return [
                'count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 0,
                'grade_distribution' => [],
                'class_distribution' => [],
            ];
        }

        $percentages = array_column($results, 'percentage');

        $grades = Grading::marks($level)->get();
        $gradeDistribution = [];
        foreach ($grades as $grade) {
            $gradeDistribution[$grade->Grade] = 0;
        }

        $classDistribution = [];
        $classes = Grading::points($level)->get();
        foreach ($classes as $class) {
            $classDistribution[$class->Grade] = 0;
        }

        foreach ($results as $result) {
            if (isset($gradeDistribution[$result['grade']])) {
                $gradeDistribution[$result['grade']]++;
            }
            if (isset($classDistribution[$result['classification']])) {
                $classDistribution[$result['classification']]++;
            }
        }

        return [
            'count' => $count,
            'average' => round(array_sum($percentages) / $count, 2),
            'highest' => max($percentages),
            'lowest' => min($percentages),
            'grade_distribution' => $gradeDistribution,
            'class_distribution' => $classDistribution,
        ];
    }

    public function getSchoolRanking(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O,P'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($category === 'UACE' ? 'A' : ($category === 'PLE' ? 'P' : 'O'));

        // Get all students for this year and category
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year");

        if ($request->school_number) {
            $studentsQuery->where('Student_ID', 'LIKE', $request->school_number . '-%');
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get results for these students
        $results = StudentResult::whereIn('student_id', $students)
            ->where('year', $year)
            ->where('category', $category)
            ->where('level', $level)
            ->get();

        // Group by school and calculate statistics
        $schoolStats = [];
        foreach ($results as $result) {
            $schoolNumber = explode('-', $result->student_id)[0];

            if (!isset($schoolStats[$schoolNumber])) {
                $schoolStats[$schoolNumber] = [
                    'school_code' => $schoolNumber,
                    'school_name' => Helper::schoolName($schoolNumber) ?? "School {$schoolNumber}",
                    'total_students' => 0,
                    'total_marks' => 0,
                    'average_percentage' => 0,
                    'grades' => [],
                    'classifications' => [],
                    'students' => []
                ];
            }

            $schoolStats[$schoolNumber]['total_students']++;
            $schoolStats[$schoolNumber]['total_marks'] += $result->percentage;
            $schoolStats[$schoolNumber]['grades'][$result->grade] =
                ($schoolStats[$schoolNumber]['grades'][$result->grade] ?? 0) + 1;
            $schoolStats[$schoolNumber]['classifications'][$result->classification] =
                ($schoolStats[$schoolNumber]['classifications'][$result->classification] ?? 0) + 1;
            $schoolStats[$schoolNumber]['students'][] = [
                'id' => $result->student_id,
                'percentage' => $result->percentage,
                'grade' => $result->grade,
                'classification' => $result->classification
            ];
        }

        // Calculate averages and sort
        foreach ($schoolStats as &$stats) {
            $stats['average_percentage'] = $stats['total_students'] > 0
                ? round($stats['total_marks'] / $stats['total_students'], 2)
                : 0;

            // Calculate pass rate (percentage of students with grade >= C4 or classification not FAIL)
            $passed = 0;
            foreach ($stats['students'] as $student) {
                if (!in_array($student['classification'], ['FAIL', 'F'])) {
                    $passed++;
                }
            }
            $stats['pass_rate'] = $stats['total_students'] > 0
                ? round(($passed / $stats['total_students']) * 100, 2)
                : 0;
        }

        // Sort by average percentage descending
        usort($schoolStats, function ($a, $b) {
            return $b['average_percentage'] <=> $a['average_percentage'];
        });

        // Add rankings
        foreach ($schoolStats as $index => &$stats) {
            $stats['rank'] = $index + 1;
        }

        // Get previous year data for comparison
        $prevYearData = $this->getPreviousYearComparison($year, $category, $level, array_keys($schoolStats));

        return response()->json([
            'success' => true,
            'data' => $schoolStats,
            'previous_year' => $prevYearData,
            'summary' => [
                'total_schools' => count($schoolStats),
                'total_students' => $results->count(),
                'average_across_schools' => count($schoolStats) > 0
                    ? round(array_sum(array_column($schoolStats, 'average_percentage')) / count($schoolStats), 2)
                    : 0,
                'top_school' => $schoolStats[0]['school_name'] ?? 'N/A',
                'top_school_score' => $schoolStats[0]['average_percentage'] ?? 0
            ]
        ]);
    }

    public function getStudentRanking(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'limit' => 'nullable|integer|min:1|max:500'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($category === 'UACE' ? 'A' : ($category === 'PLE' ? 'P' : 'O'));
        $limit = $request->limit ?? 100;
        $schoolNumber = $request->school_number;

        // Build query
        $query = StudentResult::where('year', $year)
            ->where('category', $category)
            ->where('level', $level);

        if ($schoolNumber) {
            $query->where('school_number', $schoolNumber);
        }

        // Get top students
        $topStudents = $query->orderBy('percentage', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item, $index) {
                $schoolNumber = explode('-', $item->student_id)[0];
                return [
                    'rank' => $index + 1,
                    'student_id' => $item->student_id,
                    'school' => Helper::schoolName($schoolNumber) ?? $schoolNumber,
                    'percentage' => $item->percentage,
                    'grade' => $item->grade,
                    'classification' => $item->classification,
                    'total_marks' => $item->total_marks
                ];
            });

        // Get bottom students
        $bottomStudents = StudentResult::where('year', $year)
            ->where('category', $category)
            ->where('level', $level)
            ->where('percentage', '>', 0)
            ->orderBy('percentage', 'asc')
            ->limit(min(50, $limit))
            ->get()
            ->map(function ($item, $index) {
                $schoolNumber = explode('-', $item->student_id)[0];
                return [
                    'rank' => $index + 1,
                    'student_id' => $item->student_id,
                    'school' => Helper::schoolName($schoolNumber) ?? $schoolNumber,
                    'percentage' => $item->percentage,
                    'grade' => $item->grade,
                    'classification' => $item->classification,
                    'total_marks' => $item->total_marks
                ];
            });

        // Get statistics
        $stats = [
            'total_students' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->count(),
            'average_percentage' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->avg('percentage'),
            'highest_score' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->max('percentage'),
            'lowest_score' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->min('percentage')
        ];

        return response()->json([
            'success' => true,
            'top_students' => $topStudents,
            'bottom_students' => $bottomStudents,
            'statistics' => $stats
        ]);
    }

    public function getSubjectAnalysis(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required'
        ]);

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);

        // Get all students for this year/category
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year");

        if ($schoolNumber) {
            $studentsQuery->where('Student_ID', 'LIKE', $schoolNumber . '-%');
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get marks for all subjects
        $marks = Mark::whereIn('student_id', $students)
            ->whereIn('subject_id', $subjectIds)
            ->with('subject')
            ->get()
            ->groupBy('subject_id');

        $subjectAnalysis = [];
        foreach ($subjectIds as $subjectId) {
            $subjectMarks = $marks->get($subjectId, collect());

            if ($subjectMarks->isEmpty()) {
                continue;
            }

            $marksValues = $subjectMarks->pluck('mark')->toArray();

            $analysis = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectMarks->first()->subject->md_name ?? 'Unknown',
                'total_students' => $subjectMarks->count(),
                'average_mark' => round($subjectMarks->avg('mark'), 2),
                'highest_mark' => max($marksValues),
                'lowest_mark' => min($marksValues),
                'median_mark' => $this->calculateMedian($marksValues),
                'std_deviation' => $this->calculateStdDev($marksValues),
                'pass_count' => $subjectMarks->where('mark', '>=', 50)->count(),
                'fail_count' => $subjectMarks->where('mark', '<', 50)->count(),
                'pass_rate' => round(($subjectMarks->where('mark', '>=', 50)->count() / $subjectMarks->count()) * 100, 2),
                'grade_distribution' => $this->getMarkGradeDistribution($subjectMarks->pluck('mark')->toArray())
            ];

            $subjectAnalysis[] = $analysis;
        }

        // Sort by average mark descending
        usort($subjectAnalysis, function ($a, $b) {
            return $b['average_mark'] <=> $a['average_mark'];
        });

        // Get best and worst subjects
        $bestSubjects = array_slice($subjectAnalysis, 0, 5);
        $worstSubjects = array_slice(array_reverse($subjectAnalysis), 0, 5);

        return response()->json([
            'success' => true,
            'all_subjects' => $subjectAnalysis,
            'best_subjects' => $bestSubjects,
            'worst_subjects' => $worstSubjects,
            'summary' => [
                'total_subjects' => count($subjectAnalysis),
                'overall_average' => count($subjectAnalysis) > 0
                    ? round(array_sum(array_column($subjectAnalysis, 'average_mark')) / count($subjectAnalysis), 2)
                    : 0,
                'best_subject' => $bestSubjects[0]['subject_name'] ?? 'N/A',
                'best_subject_score' => $bestSubjects[0]['average_mark'] ?? 0,
                'worst_subject' => $worstSubjects[0]['subject_name'] ?? 'N/A',
                'worst_subject_score' => $worstSubjects[0]['average_mark'] ?? 0
            ]
        ]);
    }

    public function getYearComparison(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'years' => 'required|array|min:2|max:5'
        ]);

        $category = $request->category;
        $years = $request->years;
        $level = $request->level ?? ($category === 'UACE' ? 'A' : ($category === 'PLE' ? 'P' : 'O'));
        $schoolNumber = $request->school_number;

        $comparison = [];
        $trends = [];

        foreach ($years as $year) {
            $query = StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level);

            if ($schoolNumber) {
                $query->where('school_number', $schoolNumber);
            }

            $results = $query->get();

            $yearData = [
                'year' => $year,
                'total_students' => $results->count(),
                'average_percentage' => $results->avg('percentage') ?? 0,
                'highest_percentage' => $results->max('percentage') ?? 0,
                'lowest_percentage' => $results->min('percentage') ?? 0,
                'grade_distribution' => $results->groupBy('grade')->map->count(),
                'classification_distribution' => $results->groupBy('classification')->map->count(),
                'pass_rate' => $results->whereNotIn('classification', ['FAIL', 'F'])->count() / max($results->count(), 1) * 100
            ];

            $comparison[] = $yearData;
        }

        // Calculate trends
        for ($i = 1; $i < count($comparison); $i++) {
            $current = $comparison[$i];
            $previous = $comparison[$i - 1];

            $trends[] = [
                'from_year' => $previous['year'],
                'to_year' => $current['year'],
                'average_change' => round($current['average_percentage'] - $previous['average_percentage'], 2),
                'student_count_change' => $current['total_students'] - $previous['total_students'],
                'pass_rate_change' => round($current['pass_rate'] - $previous['pass_rate'], 2)
            ];
        }

        return response()->json([
            'success' => true,
            'comparison' => $comparison,
            'trends' => $trends,
            'summary' => [
                'best_year' => collect($comparison)->sortByDesc('average_percentage')->first()['year'] ?? null,
                'best_year_avg' => collect($comparison)->max('average_percentage') ?? 0,
                'worst_year' => collect($comparison)->sortBy('average_percentage')->first()['year'] ?? null,
                'worst_year_avg' => collect($comparison)->min('average_percentage') ?? 0,
                'overall_trend' => $this->calculateOverallTrend($comparison)
            ]
        ]);
    }

    public function downloadReport($format)
    {
        $data = session('report_data');
        $filename = session('filename') . '.' . ($format == 'excel' ? 'xlsx' : $format);

        if (!$data) {
            return redirect()->back()->with('error', 'No report data found');
        }

        // Generate file based on format
        switch ($format) {
            case 'excel':
                return $this->generateExcelReport($data, $filename);
            case 'csv':
                return $this->generateCsvReport($data, $filename);
            case 'pdf':
                return $this->generatePdfReport($data, $filename);
            default:
                return redirect()->back()->with('error', 'Invalid format');
        }
    }

    private function calculateMedian($arr)
    {
        sort($arr);
        $count = count($arr);
        $middle = floor($count / 2);

        if ($count % 2) {
            return $arr[$middle];
        }

        return ($arr[$middle - 1] + $arr[$middle]) / 2;
    }

    private function calculateStdDev($arr)
    {
        $avg = array_sum($arr) / count($arr);
        $variance = 0;

        foreach ($arr as $value) {
            $variance += pow($value - $avg, 2);
        }

        return round(sqrt($variance / count($arr)), 2);
    }

    private function getMarkGradeDistribution($marks)
    {
        $distribution = [
            'A (80-100)' => 0,
            'B (70-79)' => 0,
            'C (60-69)' => 0,
            'D (50-59)' => 0,
            'F (0-49)' => 0
        ];

        foreach ($marks as $mark) {
            if ($mark >= 80)
                $distribution['A (80-100)']++;
            elseif ($mark >= 70)
                $distribution['B (70-79)']++;
            elseif ($mark >= 60)
                $distribution['C (60-69)']++;
            elseif ($mark >= 50)
                $distribution['D (50-59)']++;
            else
                $distribution['F (0-49)']++;
        }

        return $distribution;
    }
    private function calculateOverallTrend($comparison)
    {
        if (count($comparison) < 2) {
            return 'Insufficient data';
        }

        $first = $comparison[0]['average_percentage'];
        $last = $comparison[count($comparison) - 1]['average_percentage'];

        $change = $last - $first;

        if ($change > 5)
            return 'Strong improvement';
        if ($change > 2)
            return 'Slight improvement';
        if ($change > -2)
            return 'Stable';
        if ($change > -5)
            return 'Slight decline';
        return 'Significant decline';
    }
    private function generateExcelReport($data, $filename)
    {
        return response()->json(['message' => 'Excel generation not implemented']);
    }


    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
    public function examStatistics(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O,P'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($request->category === 'UACE' ? 'A' : ($request->category === 'PLE' ? 'P' : 'O'));

        // Get level name for display
        if ($level == 'A') {
            $levelName = 'A-LEVEL (UACE)';
        } elseif ($level == 'P') {
            $levelName = 'PRIMARY (P) LEVEL';
        } else {
            $levelName = 'O-LEVEL (UCE)';
        }

        // Get registered schools count
        $schoolsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        $schoolsCount = $schoolsQuery->get()
            ->map(function ($item) {
                return explode('-', $item->Student_ID)[0];
            })
            ->unique()
            ->count();

        // Get registered students count
        $registeredStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->count('Student_ID');

        // Get all students for this category/year
        $allStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students
        $marks = Mark::whereIn('student_id', $allStudents)
            ->whereIn('subject_id', $subjectIds)
            ->where('year', $year)
            ->get()
            ->groupBy('student_id');

        // Initialize grade distribution counters
        $gradeDistribution = [
            'D1' => ['male' => 0, 'female' => 0, 'total' => 0],
            'D2' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C3' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C4' => ['male' => 0, 'female' => 0, 'total' => 0],
            'F' => ['male' => 0, 'female' => 0, 'total' => 0],
        ];

        $totalMale = 0;
        $totalFemale = 0;
        $totalGraded = 0;

        // Array to store student performance data for top students
        $studentPerformance = [];

        // Initialize subject performance tracking
        $subjectPerformance = [];

        // Get subject names based on category
        if ($category == 'UACE') {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UACEPapers')
            )->get()->keyBy('id');
        } else {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UCEPapers')
            )->get()->keyBy('id');
        }

        // Initialize subject performance array with subject details
        foreach ($subjectIds as $subjectId) {

            $subject = $subjectPapers[$subjectId] ?? null;
            $subjectPerformance[$subjectId] = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectId,
                'total_marks' => 0,
                'student_count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 100,
                'pass_count' => 0,
                'fail_count' => 0,
                'pass_percentage' => 0
            ];
        }

        // Process each student
        foreach ($allStudents as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue; // Skip students with no marks
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;

            // IMPORTANT: Get ONLY the Marks type grade for the summary table
            $grade = $this->getMarksGrade($percentage, $level);

            // Get student gender
            $gender = strtolower($this->getStudentGender($studentId));

            // Get student name/info for top students list
            $studentInfo = $this->getStudentInfo($studentId);

            // Store student performance data for top students
            $studentPerformance[] = [
                'student_id' => $studentId,
                'student_name' => $studentInfo['name'] ?? 'N/A',
                'school_name' => $studentInfo['school_name'] ?? 'N/A',
                'total_marks' => $totalMarks,
                'percentage' => $percentage,
                'grade' => $grade,
                'gender' => $gender
            ];

            // Update subject performance
            foreach ($studentMarks as $mark) {
                $subjectId = $mark->subject_id;
                $markValue = $mark->mark;

                if (isset($subjectPerformance[$subjectId])) {
                    $subjectPerformance[$subjectId]['total_marks'] += $markValue;
                    $subjectPerformance[$subjectId]['student_count']++;
                    $subjectPerformance[$subjectId]['highest'] = max($subjectPerformance[$subjectId]['highest'], $markValue);
                    $subjectPerformance[$subjectId]['lowest'] = min($subjectPerformance[$subjectId]['lowest'], $markValue);

                    // Count passes (assuming pass mark is 50 or more - adjust as needed)
                    if ($markValue >= 50) {
                        $subjectPerformance[$subjectId]['pass_count']++;
                    } else {
                        $subjectPerformance[$subjectId]['fail_count']++;
                    }
                }
            }

            // Update counters
            if (isset($gradeDistribution[$grade])) {
                $gradeDistribution[$grade][$gender]++;
                $gradeDistribution[$grade]['total']++;

                if ($gender == 'male') {
                    $totalMale++;
                } else {
                    $totalFemale++;
                }
                $totalGraded++;
            }
        }

        // Calculate averages and pass percentages for subjects
        foreach ($subjectPerformance as &$subject) {
            if ($subject['student_count'] > 0) {
                $subject['average'] = round($subject['total_marks'] / $subject['student_count'], 2);
                $subject['pass_percentage'] = round(($subject['pass_count'] / $subject['student_count']) * 100, 2);
            }

            // Handle subjects with no data
            if ($subject['lowest'] == 100) {
                $subject['lowest'] = 0;
            }
        }

        // Sort subjects by average performance
        usort($subjectPerformance, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        // Get top 10 best performing subjects
        $bestSubjects = array_slice($subjectPerformance, 0, 10);

        // Get bottom 10 worst performing subjects (reverse order)
        $worstSubjects = array_slice(array_reverse($subjectPerformance), 0, 10);

        // Sort students by percentage (highest first) and get top 10
        usort($studentPerformance, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $topStudents = array_slice($studentPerformance, 0, 10);

        // Prepare grading summary table
        $gradingSummary = [];
        $serial = ['a', 'b', 'c', 'd'];
        $gradeLabels = [
            'D1' => 'Excellent D1',
            'D2' => 'Very good D2',
            'C3' => 'Good C3',
            'C4' => 'Pass C4',
            'F' => 'Fail F'
        ];


        $i = 0;
        foreach ($gradeDistribution as $grade => $counts) {
            if ($grade != 'F') { // Exclude Fail from main table
                $gradingSummary[$grade] = [
                    'serial' => $serial[$i++] ?? '',
                    'label' => $gradeLabels[$grade],
                    'male_count' => $counts['male'],
                    'male_percent' => $this->calculatePercentage($counts['male'], $totalGraded),
                    'female_count' => $counts['female'],
                    'female_percent' => $this->calculatePercentage($counts['female'], $totalGraded),
                    'total' => $counts['total']
                ];
            }
        }

        // Failed students breakdown
        $failedBreakdown = [
            'male_failed' => $gradeDistribution['F']['male'],
            'female_failed' => $gradeDistribution['F']['female'],
            'total_failed' => $gradeDistribution['F']['total']
        ];

        $totals = [
            'male_total' => $totalMale,
            'female_total' => $totalFemale,
            'overall_total' => $totalGraded
        ];

        // Prepare data tables
        $schoolsTable = [
            ['level' => $levelName, 'count' => $schoolsCount]
        ];

        $studentsRegisteredTable = [
            ['level' => $levelName, 'count' => $registeredStudents, 'total' => $registeredStudents]
        ];

        // Get years for dropdown
        $years = ClassAllocation::selectRaw('DISTINCT SUBSTRING(Student_ID, -4) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // After processing all students, calculate school performance
        $topSchools = $this->calculateSchoolPerformance(
            $allStudents,
            $marks,
            $subjectIds,
            $totalPossibleMarks,
            $level,
            $category,
            $year
        );

        $data = $this->getExamStatisticsData($request);


        // Merge $data with all other variables
        $viewData = array_merge($data, [
            'year' => $year,
            'years' => $years,
            'category' => $category,
            'level' => $level,
            'levelName' => $levelName,
            'schoolsTable' => $schoolsTable,
            'studentsRegisteredTable' => $studentsRegisteredTable,
            'gradingSummary' => $gradingSummary,
            'totals' => $totals,
            'failedBreakdown' => $failedBreakdown,
            'registeredStudents' => $registeredStudents,
            'totalGraded' => $totalGraded,
            'topStudents' => $topStudents,
            'bestSubjects' => $bestSubjects,
            'worstSubjects' => $worstSubjects,
            'topSchools' => $topSchools
        ]);

        return view('itemGrading.exam-statistics', $viewData);

    }
    private function getMarksGrade($percentage, $level)
    {
        $grade = Grading::where('Type', 'Marks')
            ->where('Level', $level)
            ->where('From', '<=', $percentage)
            ->where('To', '>=', $percentage)
            ->first();

        return $grade ? $grade->Grade : 'N/A';
    }
    private function getStudentGender($studentId)
    {
        $student = StudentBasic::where('Student_ID', $studentId)->first();

        if ($student && !empty($student->StudentSex)) {
            return $student->StudentSex;
        }

        if ($student && !empty($student->StudentSex_AR)) {
            $arabicGender = $student->StudentSex_AR;
            if (strpos($arabicGender, 'ذكر') !== false || strpos($arabicGender, 'Male') !== false) {
                return 'Male';
            } elseif (strpos($arabicGender, 'أنثى') !== false || strpos($arabicGender, 'Female') !== false) {
                return 'Female';
            }
        }

        \Log::warning("Gender not found for student: " . $studentId);
        return 'Male'; // Default fallback
    }
    private function calculatePercentage($count, $total)
    {
        return $total > 0 ? round(($count / $total) * 100, 2) : 0;
    }

    private function getStudentInfo($studentId)
    {
        $student = StudentBasic::where('Student_ID', $studentId)->first();

        if (!$student) {
            return ['name' => 'N/A', 'school_name' => 'N/A'];
        }

        // Extract school code from student ID (first part before first hyphen)
        $parts = explode('-', $studentId);
        $schoolCode = $parts[0] ?? '';

        // Get school name from schools array (you'll need to pass this or fetch it)
        $schoolName = $this->getSchoolName($schoolCode);

        return [
            // 'name' => $student->StudentName ?? $student->StudentName_AR ?? 'N/A',
            'name' => $student->Student_ID,
            'school_name' => $student->House
            // 'school_name' => $schoolName
        ];
    }

    public static function getSchoolName($school_id)
    {
        $schoolName = DB::table('houses')
            ->where('Number', $school_id)
            ->value('House');

        return $schoolName;
    }

    public static function getSchoolNameSplitted($school_code)
    {
        // If school_code is like "IT-114", we need to extract just the code part or search appropriately
        // Based on your houses table, the Number field might be just "IT-001" format
        $schoolName = DB::table('houses')
            ->where('Number', $school_code) // This should match exactly if your houses table has "IT-114"
            ->orWhere('Number', explode('-', $school_code)[0]) // Fallback to just "IT" if needed
            ->value('House');

        return $schoolName ?: $school_code;
    }

    private function calculateSchoolPerformance($allStudents, $marks, $subjectIds, $totalPossibleMarks, $level, $category, $year)
    {
        $studentsBySchool = [];

        // Group students by school (using full school code from student ID)
        foreach ($allStudents as $studentId) {
            // Extract school code (first two parts: IT-114 from IT-114-ID-001-2025)
            $parts = explode('-', $studentId);
            $schoolCode = $parts[0] . '-' . $parts[1]; // This gives "IT-114"
            $studentsBySchool[$schoolCode][] = $studentId;
        }

        $schoolPerformance = [];

        // Initialize grade counters for each school
        foreach ($studentsBySchool as $schoolCode => $studentIds) {
            $schoolName = $this->getSchoolNameSplitted($schoolCode);

            $schoolPerformance[$schoolCode] = [
                'school_code' => $schoolCode,
                'school_name' => $schoolName ?: $schoolCode,
                'total_students' => count($studentIds),
                'graded_students' => 0,
                'total_marks' => 0,
                'average_percentage' => 0,
                'pass_rate' => 0,
                'grades' => [
                    'FIRST CLASS' => 0,
                    'SECOND CLASS UPPER' => 0,
                    'SECOND CLASS LOWER' => 0,
                    'THIRD CLASS' => 0,
                    'FAIL' => 0,
                ]
            ];
        }

        // Process each student's marks and assign to schools
        foreach ($allStudents as $studentId) {
            // Extract school code consistently
            $parts = explode('-', $studentId);
            $schoolCode = $parts[0] . '-' . $parts[1]; // This gives "IT-114"

            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue;
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;

            // Get grade based on percentage and level
            $grade = $this->getSchoolGrade($percentage, $level);

            if (isset($schoolPerformance[$schoolCode])) {
                $schoolPerformance[$schoolCode]['graded_students']++;
                $schoolPerformance[$schoolCode]['total_marks'] += $totalMarks;
                $schoolPerformance[$schoolCode]['grades'][$grade]++;
            }
        }

        // Remove schools with no graded students
        $schoolPerformance = array_filter($schoolPerformance, function ($school) {
            return $school['graded_students'] > 0;
        });

        // Calculate averages and pass rates
        foreach ($schoolPerformance as &$school) {
            if ($school['graded_students'] > 0) {
                $school['average_percentage'] = round(
                    ($school['total_marks'] / ($school['graded_students'] * $totalPossibleMarks)) * 100,
                    2
                );

                // Calculate pass rate (excluding FAIL)
                $passedStudents = $school['grades']['FIRST CLASS'] +
                    $school['grades']['SECOND CLASS UPPER'] +
                    $school['grades']['SECOND CLASS LOWER'] +
                    $school['grades']['THIRD CLASS'];

                $school['pass_rate'] = $school['graded_students'] > 0
                    ? round(($passedStudents / $school['graded_students']) * 100, 2)
                    : 0;
            }
        }

        // Sort schools by average percentage (highest first)
        usort($schoolPerformance, function ($a, $b) {
            return $b['average_percentage'] <=> $a['average_percentage'];
        });

        // Return top 10 schools
        return array_slice($schoolPerformance, 0, 10);
    }
    private function getSchoolGrade($percentage, $level)
    {
        $grade = Grading::where('Type', 'Marks')
            ->where('Level', $level)
            ->where('From', '<=', $percentage)
            ->where('To', '>=', $percentage)
            ->first();

        if (!$grade) {
            return 'FAIL';
        }

        $gradeMapping = [
            'D1' => 'FIRST CLASS',
            'D2' => 'SECOND CLASS UPPER',
            'C3' => 'SECOND CLASS LOWER',
            'C4' => 'THIRD CLASS',
            'F' => 'FAIL'
        ];

        return $gradeMapping[$grade->Grade] ?? 'FAIL';
    }

    // Download Implementation 

    // Add this method to your controller
    public function downloadExamStatistics(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O,P'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($category === 'UACE' ? 'A' : ($category === 'PLE' ? 'P' : 'O'));

        if ($level == 'A') {
            $levelName = 'A-LEVEL (UACE)';
        } elseif ($level == 'P') {
            $levelName = 'PRIMARY (P) LEVEL';
        } else {
            $levelName = 'O-LEVEL (UCE)';
        }

        // Reuse the same logic from examStatistics method
        // Get registered schools count
        $schoolsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        $schoolsCount = $schoolsQuery->get()
            ->map(function ($item) {
                return explode('-', $item->Student_ID)[0];
            })
            ->unique()
            ->count();

        // Get registered students count
        $registeredStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->count('Student_ID');

        // Get all students for this category/year
        $allStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students
        $marks = Mark::whereIn('student_id', $allStudents)
            ->whereIn('subject_id', $subjectIds)
            ->where('year', $year)
            ->get()
            ->groupBy('student_id');

        // Initialize grade distribution counters
        $gradeDistribution = [
            'D1' => ['male' => 0, 'female' => 0, 'total' => 0],
            'D2' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C3' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C4' => ['male' => 0, 'female' => 0, 'total' => 0],
            'F' => ['male' => 0, 'female' => 0, 'total' => 0],
        ];

        $totalMale = 0;
        $totalFemale = 0;
        $totalGraded = 0;

        // Array to store student performance data for top students
        $studentPerformance = [];

        // Initialize subject performance tracking
        $subjectPerformance = [];

        // Get subject names based on category
        if ($category == 'UACE') {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UACEPapers')
            )->get()->keyBy('id');
        } else {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UCEPapers')
            )->get()->keyBy('id');
        }

        // Initialize subject performance array with subject details
        foreach ($subjectIds as $subjectId) {
            $subject = $subjectPapers[$subjectId] ?? null;
            $subjectPerformance[$subjectId] = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectId,
                'total_marks' => 0,
                'student_count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 100,
                'pass_count' => 0,
                'fail_count' => 0,
                'pass_percentage' => 0
            ];
        }

        // Process each student
        foreach ($allStudents as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue;
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;
            $grade = $this->getMarksGrade($percentage, $level);
            $gender = strtolower($this->getStudentGender($studentId));
            $studentInfo = $this->getStudentInfo($studentId);

            $studentPerformance[] = [
                'student_id' => $studentId,
                'student_name' => $studentInfo['name'] ?? 'N/A',
                'school_name' => $studentInfo['school_name'] ?? 'N/A',
                'total_marks' => $totalMarks,
                'percentage' => $percentage,
                'grade' => $grade,
                'gender' => $gender
            ];

            // Update subject performance
            foreach ($studentMarks as $mark) {
                $subjectId = $mark->subject_id;
                $markValue = $mark->mark;

                if (isset($subjectPerformance[$subjectId])) {
                    $subjectPerformance[$subjectId]['total_marks'] += $markValue;
                    $subjectPerformance[$subjectId]['student_count']++;
                    $subjectPerformance[$subjectId]['highest'] = max($subjectPerformance[$subjectId]['highest'], $markValue);
                    $subjectPerformance[$subjectId]['lowest'] = min($subjectPerformance[$subjectId]['lowest'], $markValue);

                    if ($markValue >= 50) {
                        $subjectPerformance[$subjectId]['pass_count']++;
                    } else {
                        $subjectPerformance[$subjectId]['fail_count']++;
                    }
                }
            }

            // Update counters
            if (isset($gradeDistribution[$grade])) {
                $gradeDistribution[$grade][$gender]++;
                $gradeDistribution[$grade]['total']++;

                if ($gender == 'male') {
                    $totalMale++;
                } else {
                    $totalFemale++;
                }
                $totalGraded++;
            }
        }

        // Calculate averages and pass percentages for subjects
        foreach ($subjectPerformance as &$subject) {
            if ($subject['student_count'] > 0) {
                $subject['average'] = round($subject['total_marks'] / $subject['student_count'], 2);
                $subject['pass_percentage'] = round(($subject['pass_count'] / $subject['student_count']) * 100, 2);
            }

            if ($subject['lowest'] == 100) {
                $subject['lowest'] = 0;
            }
        }

        // Sort subjects by average performance
        usort($subjectPerformance, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        // Get top 10 best performing subjects
        $bestSubjects = array_slice($subjectPerformance, 0, 10);

        // Get bottom 10 worst performing subjects
        $worstSubjects = array_slice(array_reverse($subjectPerformance), 0, 10);

        // Sort students by percentage and get top 10
        usort($studentPerformance, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $topStudents = array_slice($studentPerformance, 0, 10);

        // Prepare grading summary
        $gradingSummary = [];
        $serial = ['a', 'b', 'c', 'd'];
        $gradeLabels = [
            'D1' => 'Excellent D1',
            'D2' => 'Very good D2',
            'C3' => 'Good C3',
            'C4' => 'Pass C4',
            'F' => 'Fail F'
        ];

        $i = 0;
        foreach ($gradeDistribution as $grade => $counts) {
            if ($grade != 'F') {
                $gradingSummary[$grade] = [
                    'serial' => $serial[$i++] ?? '',
                    'label' => $gradeLabels[$grade],
                    'male_count' => $counts['male'],
                    'male_percent' => $this->calculatePercentage($counts['male'], $totalGraded),
                    'female_count' => $counts['female'],
                    'female_percent' => $this->calculatePercentage($counts['female'], $totalGraded),
                    'total' => $counts['total']
                ];
            }
        }

        $failedBreakdown = [
            'male_failed' => $gradeDistribution['F']['male'],
            'female_failed' => $gradeDistribution['F']['female'],
            'total_failed' => $gradeDistribution['F']['total']
        ];

        $totals = [
            'male_total' => $totalMale,
            'female_total' => $totalFemale,
            'overall_total' => $totalGraded
        ];

        // Generate Excel/CSV file
        return $this->generateExcelExport(
            $year,
            $category,
            $levelName,
            $schoolsCount,
            $registeredStudents,
            $gradingSummary,
            $totals,
            $failedBreakdown,
            $topStudents,
            $bestSubjects,
            $worstSubjects
        );
    }

    private function generateExcelExport(
        $year,
        $category,
        $levelName,
        $schoolsCount,
        $registeredStudents,
        $gradingSummary,
        $totals,
        $failedBreakdown,
        $topStudents,
        $bestSubjects,
        $worstSubjects
    ) {
        $filename = "exam_statistics_{$year}_{$category}_{$levelName}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($year, $category, $levelName, $schoolsCount, $registeredStudents, $gradingSummary, $totals, $failedBreakdown, $topStudents, $bestSubjects, $worstSubjects) {

            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Title
            fputcsv($file, ["EXAM STATISTICS REPORT - {$year} - {$category} - {$levelName}"]);
            fputcsv($file, []);

            // 1. Schools Registered
            fputcsv($file, ["1. NUMBER OF SCHOOLS REGISTERED"]);
            fputcsv($file, ["S/N", $levelName]);
            fputcsv($file, ["1", $schoolsCount]);
            fputcsv($file, []);

            // 2. Students Registered
            fputcsv($file, ["2. NUMBER OF STUDENTS REGISTERED"]);
            fputcsv($file, ["S/N", $levelName, "Total"]);
            fputcsv($file, ["1", $registeredStudents, $registeredStudents]);
            fputcsv($file, []);

            // 3. Grading Summary
            fputcsv($file, ["3. GRADING SUMMARY - {$levelName}"]);
            fputcsv($file, ["S/N", $levelName, "Male", "Male %", "Female", "Female %", "Total"]);

            $gradeOrder = ['D1', 'D2', 'C3', 'C4'];
            $serial = ['a', 'b', 'c', 'd'];
            $labels = ['Excellent D1', 'Very good D2', 'Good C3', 'Pass C4'];

            foreach ($gradeOrder as $index => $grade) {
                if (isset($gradingSummary[$grade])) {
                    fputcsv($file, [
                        $serial[$index] . '.',
                        $labels[$index],
                        $gradingSummary[$grade]['male_count'],
                        $gradingSummary[$grade]['male_percent'] . '%',
                        $gradingSummary[$grade]['female_count'],
                        $gradingSummary[$grade]['female_percent'] . '%',
                        $gradingSummary[$grade]['total']
                    ]);
                }
            }

            // Totals row
            fputcsv($file, [
                '',
                'Total',
                $totals['male_total'],
                $totals['male_total'] > 0 ? round(($totals['male_total'] / $totals['overall_total']) * 100, 2) . '%' : '0%',
                $totals['female_total'],
                $totals['female_total'] > 0 ? round(($totals['female_total'] / $totals['overall_total']) * 100, 2) . '%' : '0%',
                $totals['overall_total']
            ]);
            fputcsv($file, []);

            // 4. Failed Students
            fputcsv($file, ["4. STUDENTS FAILED"]);
            fputcsv($file, ["S/N", $levelName, "Male", "Female", "Total"]);
            fputcsv($file, ["1", "", $failedBreakdown['male_failed'], $failedBreakdown['female_failed'], $failedBreakdown['total_failed']]);
            fputcsv($file, []);

            // 5. Top 10 Students
            fputcsv($file, ["5. TOP 10 PERFORMING STUDENTS - {$levelName}"]);
            fputcsv($file, ["Rank", "Student ID", "Student Name", "School", "Gender", "Total Marks", "Percentage"]);

            foreach ($topStudents as $index => $student) {
                $rank = $index + 1;
                $rankText = $rank . ($rank == 1 ? 'st' : ($rank == 2 ? 'nd' : ($rank == 3 ? 'rd' : 'th')));
                fputcsv($file, [
                    $rankText,
                    $student['student_id'],
                    $student['student_name'],
                    $student['school_name'],
                    ucfirst($student['gender']),
                    number_format($student['total_marks'], 2),
                    number_format($student['percentage'], 2) . '%'
                ]);
            }
            fputcsv($file, []);

            // Top 10 summary
            fputcsv($file, ["Top 10 Summary"]);
            fputcsv($file, [
                "Average Percentage: " . number_format(collect($topStudents)->avg('percentage'), 2) . "%",
                "Male Count: " . collect($topStudents)->where('gender', 'male')->count(),
                "Female Count: " . collect($topStudents)->where('gender', 'female')->count(),
                "Top Score: " . (isset($topStudents[0]) ? number_format($topStudents[0]['percentage'], 2) . '%' : '0%')
            ]);
            fputcsv($file, []);

            // 6. Best Performing Subjects
            fputcsv($file, ["6. TOP 10 BEST PERFORMING SUBJECTS"]);
            fputcsv($file, ["Rank", "Subject Name", "Students", "Average %", "Highest %", "Pass Rate %"]);

            foreach ($bestSubjects as $index => $subject) {
                $rank = $index + 1;
                fputcsv($file, [
                    $rank,
                    $subject['subject_name'],
                    $subject['student_count'],
                    number_format($subject['average'], 2),
                    $subject['highest'],
                    $subject['pass_percentage']
                ]);
            }
            fputcsv($file, []);

            // 7. Worst Performing Subjects
            fputcsv($file, ["7. TOP 10 WORST PERFORMING SUBJECTS"]);
            fputcsv($file, ["Rank", "Subject Name", "Students", "Average %", "Lowest %", "Pass Rate %"]);

            foreach ($worstSubjects as $index => $subject) {
                $rank = $index + 1;
                fputcsv($file, [
                    $rank,
                    $subject['subject_name'],
                    $subject['student_count'],
                    number_format($subject['average'], 2),
                    $subject['lowest'],
                    $subject['pass_percentage']
                ]);
            }
            fputcsv($file, []);

            // Overall Summary
            fputcsv($file, ["OVERALL SUMMARY"]);
            fputcsv($file, ["Registered Students", $registeredStudents]);
            fputcsv($file, ["Graded Students", $totals['overall_total']]);
            fputcsv($file, ["Failed Students", $failedBreakdown['total_failed']]);
            fputcsv($file, [
                "Pass Rate",
                $totals['overall_total'] > 0 ?
                round((($totals['overall_total'] - $failedBreakdown['total_failed']) / $totals['overall_total']) * 100, 2) . '%' : '0%'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // Add this method for Excel download
    public function downloadExamStatisticsExcel(Request $request)
    {
        $data = $this->prepareStatisticsData($request);
        $filename = "exam_statistics_{$data['year']}_{$data['category']}_{$data['levelName']}.xlsx";

        return Excel::download(new ExamStatisticsExport($data), $filename);
    }

    // Add this method for PDF download
    public function downloadExamStatisticsPdf(Request $request)
    {
        try {
            $request->validate([
                'year' => 'required',
                'category' => 'required',
                'level' => 'nullable|in:A,O,P'
            ]);

            $data = $this->prepareStatisticsData($request);

            // Create mPDF instance with Arabic font support
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'default_font' => 'dejavusans',
                'tempDir' => storage_path('tmp'),
                'autoArabic' => true,
                'autoLangToFont' => true,
                'allow_charset_conversion' => true,
                'charset_in' => 'UTF-8',
                'useAdobeCJK' => true,
                'useSubstitutions' => true,
                'directionality' => 'ltr',
            ]);

            // Add custom fonts for better Arabic support
            $mpdf->fontdata = [
                'dejavusans' => [
                    'R' => 'DejaVuSans.ttf',
                    'B' => 'DejaVuSans-Bold.ttf',
                    'I' => 'DejaVuSans-Oblique.ttf',
                    'BI' => 'DejaVuSans-BoldOblique.ttf',
                ],
                'amiri' => [
                    'R' => 'amiri-regular.ttf',
                    'B' => 'amiri-bold.ttf',
                    'I' => 'amiri-italic.ttf',
                    'BI' => 'amiri-bolditalic.ttf',
                ]
            ];

            // Set font
            $mpdf->SetFont('dejavusans');

            // Enable Arabic
            $mpdf->SetDirectionality('ltr');

            // Set document properties
            $mpdf->SetTitle("Exam Statistics Report - {$data['year']}");
            $mpdf->SetAuthor('ITEB System');

            // Generate HTML content
            $html = view('itemGrading.pdf.exam-statistics-mpdf', $data)->render();

            // Ensure proper encoding
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

            // Write to PDF
            $mpdf->WriteHTML($html);

            // Generate filename
            $filename = "exam_statistics_{$data['year']}_{$data['category']}_{$data['level']}.pdf";

            // Output PDF
            return $mpdf->Output($filename, 'D');

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // Extract common logic to prepare data
    private function prepareStatisticsData($request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O,P'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($request->category === 'UACE' ? 'A' : ($request->category === 'PLE' ? 'P' : 'O'));

        if ($level == 'A') {
            $levelName = 'A-LEVEL (UACE)';
        } elseif ($level == 'P') {
            $levelName = 'PRIMARY (P) LEVEL';
        } else {
            $levelName = 'O-LEVEL (UCE)';
        }

        // Get registered schools count
        $schoolsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        $schoolsCount = $schoolsQuery->get()
            ->map(function ($item) {
                return explode('-', $item->Student_ID)[0];
            })
            ->unique()
            ->count();

        // Get registered students count
        $registeredStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->count('Student_ID');

        // Get all students for this category/year
        $allStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students
        $marks = Mark::whereIn('student_id', $allStudents)
            ->whereIn('subject_id', $subjectIds)
            ->where('year', $year)
            ->get()
            ->groupBy('student_id');

        // Initialize grade distribution counters
        $gradeDistribution = [
            'D1' => ['male' => 0, 'female' => 0, 'total' => 0],
            'D2' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C3' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C4' => ['male' => 0, 'female' => 0, 'total' => 0],
            'F' => ['male' => 0, 'female' => 0, 'total' => 0],
        ];

        $totalMale = 0;
        $totalFemale = 0;
        $totalGraded = 0;

        // Array to store student performance data for top students
        $studentPerformance = [];

        // Initialize subject performance tracking
        $subjectPerformance = [];

        // Get subject names based on category
        if ($category == 'UACE') {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UACEPapers')
            )->get()->keyBy('id');
        } else {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UCEPapers')
            )->get()->keyBy('id');
        }

        // Initialize subject performance array with subject details
        foreach ($subjectIds as $subjectId) {
            $subject = $subjectPapers[$subjectId] ?? null;
            $subjectPerformance[$subjectId] = [
                'subject_id' => $subjectId,
                'subject_name' => $subject ? ($subject->master_name ?? $subject->master_name_ar ?? 'Unknown Subject') : 'Unknown Subject',
                'total_marks' => 0,
                'student_count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 100,
                'pass_count' => 0,
                'fail_count' => 0,
                'pass_percentage' => 0
            ];
        }

        // Process each student
        foreach ($allStudents as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue;
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;
            $grade = $this->getMarksGrade($percentage, $level);
            $gender = strtolower($this->getStudentGender($studentId));
            $studentInfo = $this->getStudentInfo($studentId);

            $studentPerformance[] = [
                'student_id' => $studentId,
                'student_name' => $studentInfo['name'] ?? 'N/A',
                'school_name' => $studentInfo['school_name'] ?? 'N/A',
                'total_marks' => $totalMarks,
                'percentage' => $percentage,
                'grade' => $grade,
                'gender' => $gender
            ];

            // Update subject performance
            foreach ($studentMarks as $mark) {
                $subjectId = $mark->subject_id;
                $markValue = $mark->mark;

                if (isset($subjectPerformance[$subjectId])) {
                    $subjectPerformance[$subjectId]['total_marks'] += $markValue;
                    $subjectPerformance[$subjectId]['student_count']++;
                    $subjectPerformance[$subjectId]['highest'] = max($subjectPerformance[$subjectId]['highest'], $markValue);
                    $subjectPerformance[$subjectId]['lowest'] = min($subjectPerformance[$subjectId]['lowest'], $markValue);

                    if ($markValue >= 50) {
                        $subjectPerformance[$subjectId]['pass_count']++;
                    } else {
                        $subjectPerformance[$subjectId]['fail_count']++;
                    }
                }
            }

            // Update counters
            if (isset($gradeDistribution[$grade])) {
                $gradeDistribution[$grade][$gender]++;
                $gradeDistribution[$grade]['total']++;

                if ($gender == 'male') {
                    $totalMale++;
                } else {
                    $totalFemale++;
                }
                $totalGraded++;
            }
        }

        // Calculate averages and pass percentages for subjects
        foreach ($subjectPerformance as &$subject) {
            if ($subject['student_count'] > 0) {
                $subject['average'] = round($subject['total_marks'] / $subject['student_count'], 2);
                $subject['pass_percentage'] = round(($subject['pass_count'] / $subject['student_count']) * 100, 2);
            }

            if ($subject['lowest'] == 100) {
                $subject['lowest'] = 0;
            }
        }

        // Sort subjects by average performance
        usort($subjectPerformance, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        // Get top 10 best performing subjects
        $bestSubjects = array_slice($subjectPerformance, 0, 10);

        // Get bottom 10 worst performing subjects
        $worstSubjects = array_slice(array_reverse($subjectPerformance), 0, 10);

        // Sort students by percentage and get top 10
        usort($studentPerformance, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $topStudents = array_slice($studentPerformance, 0, 10);


        // Prepare grading summary
        $gradingSummary = [];
        $serial = ['a', 'b', 'c', 'd'];
        $gradeLabels = [
            'D1' => 'Excellent D1',
            'D2' => 'Very good D2',
            'C3' => 'Good C3',
            'C4' => 'Pass C4',
            'F' => 'Fail F'
        ];

        $i = 0;
        foreach ($gradeDistribution as $grade => $counts) {
            if ($grade != 'F') {
                $gradingSummary[$grade] = [
                    'serial' => $serial[$i++] ?? '',
                    'label' => $gradeLabels[$grade],
                    'male_count' => $counts['male'],
                    'male_percent' => $this->calculatePercentage($counts['male'], $totalGraded),
                    'female_count' => $counts['female'],
                    'female_percent' => $this->calculatePercentage($counts['female'], $totalGraded),
                    'total' => $counts['total']
                ];
            }
        }

        $failedBreakdown = [
            'male_failed' => $gradeDistribution['F']['male'],
            'female_failed' => $gradeDistribution['F']['female'],
            'total_failed' => $gradeDistribution['F']['total']
        ];

        $totals = [
            'male_total' => $totalMale,
            'female_total' => $totalFemale,
            'overall_total' => $totalGraded
        ];

        return [
            'year' => $year,
            'category' => $category,
            'level' => $level,
            'levelName' => $levelName,
            'schoolsCount' => $schoolsCount,
            'registeredStudents' => $registeredStudents,
            'gradingSummary' => $gradingSummary,
            'totals' => $totals,
            'failedBreakdown' => $failedBreakdown,
            'topStudents' => $topStudents,
            'bestSubjects' => $bestSubjects,
            'worstSubjects' => $worstSubjects,
        ];
    }

    public function downloadStudentsReport(Request $request)
    {
        try {
            $request->validate([
                'year' => 'required',
                'category' => 'required',
                'level' => 'nullable|in:A,O,P'
            ]);

            ini_set('memory_limit', '1024M');
            set_time_limit(600);

            \Log::info('Download Students Report Started', $request->all());

            // Get basic data
            $data = $this->getExamStatisticsBasicData($request);

            // Create temporary directory for chunks
            $tempDir = storage_path('app/temp/pdf_chunks_' . uniqid());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            \Log::info('Temp directory created: ' . $tempDir);

            // Generate header page
            $headerPdf = PDF::loadView('itemGrading.pdf.students-report-header', $data);
            $headerPdf->setPaper('A4', 'landscape');
            $headerPdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'dpi' => 96,
            ]);
            $headerPath = $tempDir . '/header.pdf';
            file_put_contents($headerPath, $headerPdf->output());

            if (!file_exists($headerPath)) {
                throw new \Exception('Failed to create header PDF');
            }

            \Log::info('Header PDF created');

            // Process students in chunks
            $chunkSize = 100;
            $allStudents = $data['all_student_ids'];
            $chunkFiles = [];

            for ($i = 0; $i < count($allStudents); $i += $chunkSize) {
                $chunkIds = array_slice($allStudents, $i, $chunkSize);

                // Get chunk data
                $chunkData = $this->getStudentChunkData($chunkIds, $request);

                if (empty($chunkData)) {
                    continue;
                }

                $chunkInfo = [
                    'students' => $chunkData,
                    'chunk_number' => floor($i / $chunkSize) + 1,
                    'total_chunks' => ceil(count($allStudents) / $chunkSize),
                    'start_index' => $i + 1,
                    'end_index' => min($i + $chunkSize, count($allStudents))
                ];

                // Generate PDF for this chunk
                $chunkPdf = PDF::loadView('itemGrading.pdf.students-report-chunk', $chunkInfo);
                $chunkPdf->setPaper('A4', 'landscape');
                $chunkPdf->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                    'dpi' => 96,
                ]);

                $chunkPath = $tempDir . '/chunk_' . floor($i / $chunkSize) . '.pdf';
                file_put_contents($chunkPath, $chunkPdf->output());

                if (file_exists($chunkPath)) {
                    $chunkFiles[] = $chunkPath;
                    \Log::info('Chunk ' . floor($i / $chunkSize) . ' created with ' . count($chunkData) . ' students');
                }

                // Clear memory
                unset($chunkData);
                unset($chunkPdf);
                gc_collect_cycles();
            }

            if (empty($chunkFiles)) {
                throw new \Exception('No data chunks were generated');
            }

            // Generate footer
            $footerPdf = PDF::loadView('itemGrading.pdf.students-report-footer', ['total' => count($allStudents)]);
            $footerPdf->setPaper('A4', 'landscape');
            $footerPath = $tempDir . '/footer.pdf';
            file_put_contents($footerPath, $footerPdf->output());

            if (!file_exists($footerPath)) {
                throw new \Exception('Failed to create footer PDF');
            }

            \Log::info('Footer PDF created');

            // Merge all PDFs using FPDI
            $finalPdf = new FPDI();

            // Merge header
            $this->mergePdfFile($finalPdf, $headerPath);

            // Merge all chunks
            foreach ($chunkFiles as $chunkFile) {
                $this->mergePdfFile($finalPdf, $chunkFile);
            }

            // Merge footer
            $this->mergePdfFile($finalPdf, $footerPath);

            // Save final PDF
            $filename = 'students_full_report_' . $request->year . '_' . $request->category . '.pdf';
            $finalPath = $tempDir . '/' . $filename;

            // Output the PDF to file
            $finalPdf->Output('F', $finalPath);

            \Log::info('Final PDF saved to: ' . $finalPath);

            // Verify file exists
            if (!file_exists($finalPath)) {
                throw new \Exception('Final PDF file was not created at: ' . $finalPath);
            }

            if (filesize($finalPath) === 0) {
                throw new \Exception('Final PDF file is empty');
            }

            \Log::info('Final PDF size: ' . filesize($finalPath) . ' bytes');

            // Return file download
            return response()->download($finalPath, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Length' => filesize($finalPath)
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Clean up temp directory if it exists
            if (isset($tempDir) && file_exists($tempDir)) {
                $this->cleanupTempDir($tempDir);
            }

            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    private function mergePdfFile($finalPdf, $filePath)
    {
        try {
            if (!file_exists($filePath)) {
                \Log::error('File not found for merging: ' . $filePath);
                return 0;
            }

            $pageCount = $finalPdf->setSourceFile($filePath);
            \Log::info('Merging file: ' . $filePath . ' with ' . $pageCount . ' pages');

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $finalPdf->importPage($pageNo);
                $size = $finalPdf->getTemplateSize($templateId);

                $finalPdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $finalPdf->useTemplate($templateId);
            }

            return $pageCount;
        } catch (\Exception $e) {
            \Log::error('Error merging PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    private function cleanupTempDir($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($dir);

        \Log::info('Cleaned up temp directory: ' . $dir);
    }

    private function getExamStatisticsBasicData($request)
    {
        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($request->category === 'UACE' ? 'A' : ($request->category === 'PLE' ? 'P' : 'O'));

        if ($level == 'A') {
            $levelName = 'A-LEVEL (UACE)';
        } elseif ($level == 'P') {
            $levelName = 'PRIMARY (P) LEVEL';
        } else {
            $levelName = 'O-LEVEL (UCE)';
        }

        // Get all student IDs
        $allStudentIds = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for percentage calculation to sort later
        $subjectIds = $this->getSubjectIdsForCategory($category);
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get marks for ALL students to calculate percentages for sorting
        $marks = Mark::whereIn('student_id', $allStudentIds)
            ->whereIn('subject_id', $subjectIds)
            ->where('year', $year)
            ->get()
            ->groupBy('student_id');

        // Calculate percentage for each student and sort
        $studentsWithPercentage = [];
        foreach ($allStudentIds as $studentId) {
            $studentMarks = $marks->get($studentId, collect());
            if ($studentMarks->isNotEmpty()) {
                $totalMarks = $studentMarks->sum('mark');
                $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;
                $studentsWithPercentage[] = [
                    'id' => $studentId,
                    'percentage' => $percentage
                ];
            }
        }

        // Sort by percentage descending
        usort($studentsWithPercentage, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // Extract just the IDs in sorted order
        $sortedStudentIds = array_column($studentsWithPercentage, 'id');

        $registeredStudents = count($sortedStudentIds);

        return [
            'year' => $year,
            'category' => $category,
            'level' => $level,
            'levelName' => $levelName,
            'registeredStudents' => $registeredStudents,
            'all_student_ids' => $sortedStudentIds, // Now this is sorted by percentage
            'generation_date' => now()->format('Y-m-d H:i:s')
        ];
    }

    private function getStudentChunkData($studentIds, $request)
    {
        try {
            $year = $request->year;
            $category = $request->category;
            $level = $request->level ?? ($request->category === 'UACE' ? 'A' : ($request->category === 'PLE' ? 'P' : 'O'));

            // Get subjects for this category
            $subjectIds = $this->getSubjectIdsForCategory($category);
            $totalPossibleMarks = count($subjectIds) * 100;

            // Get marks for these students
            $marks = Mark::whereIn('student_id', $studentIds)
                ->whereIn('subject_id', $subjectIds)
                ->where('year', $year)
                ->get()
                ->groupBy('student_id');

            $studentsData = [];

            foreach ($studentIds as $studentId) {
                $studentMarks = $marks->get($studentId, collect());

                if ($studentMarks->isEmpty()) {
                    continue;
                }

                $totalMarks = $studentMarks->sum('mark');
                $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;
                $grade = $this->getMarksGrade($percentage, $level);
                $gender = strtolower($this->getStudentGender($studentId));
                $studentInfo = $this->getStudentInfo($studentId);

                $studentsData[] = [
                    'student_id' => $studentId,
                    'student_name' => $studentInfo['name'] ?? 'N/A',
                    'school_name' => $studentInfo['school_name'] ?? 'N/A',
                    'total_marks' => $totalMarks,
                    'percentage' => $percentage,
                    'grade' => $grade,
                    'gender' => $gender
                ];
            }

            // Sort by percentage in DESCENDING order (highest first)
            usort($studentsData, function ($a, $b) {
                return $b['percentage'] <=> $a['percentage'];
            });

            \Log::info('Chunk data retrieved: ' . count($studentsData) . ' students');

            return $studentsData;

        } catch (\Exception $e) {
            \Log::error('Error in getStudentChunkData: ' . $e->getMessage());
            return [];
        }
    }
    public function downloadSchoolsReport(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O,P'
        ]);

        // Get all data
        $data = $this->getExamStatisticsData($request);

        // Generate PDF with ALL schools
        $pdf = PDF::loadView('itemGrading.pdf.schools-report', $data);

        $filename = 'schools_full_report_' . $request->year . '_' . $request->category . '.pdf';
        return $pdf->download($filename);
    }

    private function getExamStatisticsData($request)
    {
        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? ($request->category === 'UACE' ? 'A' : ($request->category === 'PLE' ? 'P' : 'O'));

        // Get level name for display
        if ($level == 'A') {
            $levelName = 'A-LEVEL (UACE)';
        } elseif ($level == 'P') {
            $levelName = 'PRIMARY (P) LEVEL';
        } else {
            $levelName = 'O-LEVEL (UCE)';
        }

        // Get registered schools count
        $schoolsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        $schoolsCount = $schoolsQuery->get()
            ->map(function ($item) {
                return explode('-', $item->Student_ID)[0];
            })
            ->unique()
            ->count();

        // Get registered students count
        $registeredStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->count('Student_ID');

        // Get all students for this category/year
        $allStudents = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students
        $marks = Mark::whereIn('student_id', $allStudents)
            ->whereIn('subject_id', $subjectIds)
            ->where('year', $year)
            ->get()
            ->groupBy('student_id');

        // Initialize grade distribution counters
        $gradeDistribution = [
            'D1' => ['male' => 0, 'female' => 0, 'total' => 0],
            'D2' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C3' => ['male' => 0, 'female' => 0, 'total' => 0],
            'C4' => ['male' => 0, 'female' => 0, 'total' => 0],
            'F' => ['male' => 0, 'female' => 0, 'total' => 0],
        ];

        $totalMale = 0;
        $totalFemale = 0;
        $totalGraded = 0;

        // Array to store ALL student performance data (not just top 10)
        $allStudentPerformance = [];

        // Initialize subject performance tracking
        $subjectPerformance = [];

        // Get subject names based on category
        if ($category == 'UACE') {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UACEPapers')
            )->get()->keyBy('id');
        } else {
            $subjectPapers = MasterData::where(
                'md_master_code_id',
                config('constants.options.UCEPapers')
            )->get()->keyBy('id');
        }

        // Initialize subject performance array with subject details
        foreach ($subjectIds as $subjectId) {
            $subject = $subjectPapers[$subjectId] ?? null;
            $subjectPerformance[$subjectId] = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectId,
                'total_marks' => 0,
                'student_count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 100,
                'pass_count' => 0,
                'fail_count' => 0,
                'pass_percentage' => 0
            ];
        }

        // Process each student
        foreach ($allStudents as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue;
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;

            // Get grade
            $grade = $this->getMarksGrade($percentage, $level);

            // Get student gender
            $gender = strtolower($this->getStudentGender($studentId));

            // Get student info
            $studentInfo = $this->getStudentInfo($studentId);

            // Store ALL student performance data
            $allStudentPerformance[] = [
                'student_id' => $studentId,
                'student_name' => $studentInfo['name'] ?? 'N/A',
                'school_name' => $studentInfo['school_name'] ?? 'N/A',
                'total_marks' => $totalMarks,
                'percentage' => $percentage,
                'grade' => $grade,
                'gender' => $gender
            ];

            // Update subject performance
            foreach ($studentMarks as $mark) {
                $subjectId = $mark->subject_id;
                $markValue = $mark->mark;

                if (isset($subjectPerformance[$subjectId])) {
                    $subjectPerformance[$subjectId]['total_marks'] += $markValue;
                    $subjectPerformance[$subjectId]['student_count']++;
                    $subjectPerformance[$subjectId]['highest'] = max($subjectPerformance[$subjectId]['highest'], $markValue);
                    $subjectPerformance[$subjectId]['lowest'] = min($subjectPerformance[$subjectId]['lowest'], $markValue);

                    if ($markValue >= 50) {
                        $subjectPerformance[$subjectId]['pass_count']++;
                    } else {
                        $subjectPerformance[$subjectId]['fail_count']++;
                    }
                }
            }

            // Update counters
            if (isset($gradeDistribution[$grade])) {
                $gradeDistribution[$grade][$gender]++;
                $gradeDistribution[$grade]['total']++;

                if ($gender == 'male') {
                    $totalMale++;
                } else {
                    $totalFemale++;
                }
                $totalGraded++;
            }
        }

        // Calculate subject averages
        foreach ($subjectPerformance as &$subject) {
            if ($subject['student_count'] > 0) {
                $subject['average'] = round($subject['total_marks'] / $subject['student_count'], 2);
                $subject['pass_percentage'] = round(($subject['pass_count'] / $subject['student_count']) * 100, 2);
            }
            if ($subject['lowest'] == 100) {
                $subject['lowest'] = 0;
            }
        }

        // Sort subjects by average
        usort($subjectPerformance, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        // Get top 10 subjects
        $bestSubjects = array_slice($subjectPerformance, 0, 10);
        $worstSubjects = array_slice(array_reverse($subjectPerformance), 0, 10);

        // Sort ALL students by percentage
        usort($allStudentPerformance, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // Get top 10 for display
        $topStudents = array_slice($allStudentPerformance, 0, 10);

        // Prepare grading summary
        $gradingSummary = [];
        $serial = ['a', 'b', 'c', 'd'];
        $gradeLabels = [
            'D1' => 'Excellent D1',
            'D2' => 'Very good D2',
            'C3' => 'Good C3',
            'C4' => 'Pass C4',
            'F' => 'Fail F'
        ];

        $i = 0;
        foreach ($gradeDistribution as $grade => $counts) {
            if ($grade != 'F') {
                $gradingSummary[$grade] = [
                    'serial' => $serial[$i++] ?? '',
                    'label' => $gradeLabels[$grade],
                    'male_count' => $counts['male'],
                    'male_percent' => $this->calculatePercentage($counts['male'], $totalGraded),
                    'female_count' => $counts['female'],
                    'female_percent' => $this->calculatePercentage($counts['female'], $totalGraded),
                    'total' => $counts['total']
                ];
            }
        }

        // Failed breakdown
        $failedBreakdown = [
            'male_failed' => $gradeDistribution['F']['male'],
            'female_failed' => $gradeDistribution['F']['female'],
            'total_failed' => $gradeDistribution['F']['total']
        ];

        $totals = [
            'male_total' => $totalMale,
            'female_total' => $totalFemale,
            'overall_total' => $totalGraded
        ];

        $schoolsTable = [
            ['level' => $levelName, 'count' => $schoolsCount]
        ];

        // Calculate school performance
        $allSchools = $this->calculateAllSchoolsPerformance(
            $allStudents,
            $marks,
            $subjectIds,
            $totalPossibleMarks,
            $level,
            $category,
            $year
        );

        $topSchools = array_slice($allSchools, 0, 10);

        // Return all data as an array
        return [
            'year' => $year,
            'category' => $category,
            'level' => $level,
            'levelName' => $levelName,
            'schoolsTable' => $schoolsTable,
            'gradingSummary' => $gradingSummary,
            'totals' => $totals,
            'failedBreakdown' => $failedBreakdown,
            'registeredStudents' => $registeredStudents,
            'totalGraded' => $totalGraded,
            'allStudents' => $allStudentPerformance, // ALL students for full report
            'topStudents' => $topStudents, // Top 10 for display
            'bestSubjects' => $bestSubjects,
            'worstSubjects' => $worstSubjects,
            'allSchools' => $allSchools, // ALL schools for full report
            'topSchools' => $topSchools, // Top 10 for display
            'subjectPerformance' => $subjectPerformance,
            'gradeDistribution' => $gradeDistribution
        ];
    }

    private function calculateAllSchoolsPerformance($allStudents, $marks, $subjectIds, $totalPossibleMarks, $level, $category, $year)
    {
        $studentsBySchool = [];

        foreach ($allStudents as $studentId) {
            $parts = explode('-', $studentId);
            $schoolCode = $parts[0] . '-' . $parts[1];
            $studentsBySchool[$schoolCode][] = $studentId;
        }

        $schoolPerformance = [];

        foreach ($studentsBySchool as $schoolCode => $studentIds) {
            $schoolName = $this->getSchoolNameSplitted($schoolCode);

            $schoolPerformance[$schoolCode] = [
                'school_code' => $schoolCode,
                'school_name' => $schoolName ?: $schoolCode,
                'total_students' => count($studentIds),
                'graded_students' => 0,
                'total_marks' => 0,
                'average_percentage' => 0,
                'pass_rate' => 0,
                'grades' => [
                    'FIRST CLASS' => 0,
                    'SECOND CLASS UPPER' => 0,
                    'SECOND CLASS LOWER' => 0,
                    'THIRD CLASS' => 0,
                    'FAIL' => 0,
                ]
            ];
        }

        foreach ($allStudents as $studentId) {
            $parts = explode('-', $studentId);
            $schoolCode = $parts[0] . '-' . $parts[1];

            $studentMarks = $marks->get($studentId, collect());

            if ($studentMarks->isEmpty()) {
                continue;
            }

            $totalMarks = $studentMarks->sum('mark');
            $percentage = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 2) : 0;
            $grade = $this->getSchoolGrade($percentage, $level);

            if (isset($schoolPerformance[$schoolCode])) {
                $schoolPerformance[$schoolCode]['graded_students']++;
                $schoolPerformance[$schoolCode]['total_marks'] += $totalMarks;
                $schoolPerformance[$schoolCode]['grades'][$grade]++;
            }
        }

        $schoolPerformance = array_filter($schoolPerformance, function ($school) {
            return $school['graded_students'] > 0;
        });

        foreach ($schoolPerformance as &$school) {
            if ($school['graded_students'] > 0) {
                $school['average_percentage'] = round(
                    ($school['total_marks'] / ($school['graded_students'] * $totalPossibleMarks)) * 100,
                    2
                );

                $passedStudents = $school['grades']['FIRST CLASS'] +
                    $school['grades']['SECOND CLASS UPPER'] +
                    $school['grades']['SECOND CLASS LOWER'] +
                    $school['grades']['THIRD CLASS'];

                $school['pass_rate'] = $school['graded_students'] > 0
                    ? round(($passedStudents / $school['graded_students']) * 100, 2)
                    : 0;
            }
        }

        usort($schoolPerformance, function ($a, $b) {
            return $b['average_percentage'] <=> $a['average_percentage'];
        });

        return $schoolPerformance; // Return ALL schools
    }

    public function schoolPasswordsSetup(Request $request)
    {
        $houses = House::select('Number', 'House', 'House_AR')
            ->get()
            ->map(function ($house) {
                return (object) [
                    'ID' => $house->Number,
                    'House' => $house->House,
                    'House_AR' => $house->House_AR,
                    'Number' => $house->Number,
                ];
            });

        return view('itemGrading.school-passwords-setup', compact('houses'));
    }

    public function fetchPassword(Request $request)
    {

        $request->validate([
            'school_id' => 'required|exists:houses,Number'
        ]);

        $school = House::where('Number', $request->school_id)->first();

        $passwordData = null;

        if ($school->schoolPassword) {
            $passwordData = [
                'id' => $school->schoolPassword->id,
                'school_id' => $school->ID,
                'school_name' => $school->House . ' - ' . $school->House_AR,
                'password_plain' => $school->schoolPassword->password_plain,
                'has_password' => true
            ];
        } else {
            $passwordData = [
                'school_id' => $school->ID,
                'school_name' => $school->House . ' - ' . $school->House_AR,
                'has_password' => false
            ];
        }

        return response()->json($passwordData);
    }

    public function generatePassword(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:houses,ID'
        ]);

        // Generate a secure random password
        $password = $this->generateSecurePassword();

        return response()->json([
            'school_id' => $request->school_id,
            'generated_password' => $password
        ]);
    }

    public function savePassword(Request $request)
    {

        $request->validate([
            'school_id' => 'required|exists:houses,ID',
            'password' => 'required'
        ]);

        $uniqueSchoolId = House::where('ID', $request->school_id)->value('Number');

        $schoolPassword = SchoolPassword::updateOrCreate(
            ['school_id' => $uniqueSchoolId],
            [
                'password_plain' => $request->password,
                'password_hashed' => Hash::make($request->password)
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Password saved successfully',
            'data' => [
                'id' => $schoolPassword->id,
                'school_id' => $schoolPassword->school_id,
                'password_plain' => $schoolPassword->password_plain
            ]
        ]);
    }
    private function generateSecurePassword($length = 5)
    {
        $numbers = '0123456789';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        }

        return $password;
    }

}