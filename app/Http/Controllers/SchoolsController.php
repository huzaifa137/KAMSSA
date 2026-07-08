<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use Illuminate\Http\Request;
use App\Models\ClassAllocation;
use App\Models\StudentBasic;
use App\Models\SubmissionDocument;
use App\Http\Controllers\Helper;
use App\Models\Grading;
use App\Models\AcademicYear;
use App\Models\MasterData;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SchoolPassword;
use App\Models\StudentRegistration;
use App\Models\SchoolRegistrationSlot;
use App\Models\SchoolSlotHistory;
use App\Models\RegistrationPeriod;
use Illuminate\Support\Facades\Log;
use App\Models\House;
use Carbon\Carbon;
use DB;

class SchoolsController extends Controller
{

    public function schoolDashboard()
    {
        $academicYears = AcademicYear::orderBy('year_en', 'desc')->get();
        $activeYear = AcademicYear::where('status', 'Active')->value('year_en');

        $categories = ['TH' => 'Thanawi', 'ID' => 'Idaad', 'PLE' => 'Primary (PLE)'];

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

        return view('GeneralSchools.dashboard', compact(
            'academicYears',
            'activeYear',
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
        $level = $request->level ?? 'A';

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
    private function getSubjectIdsForCategory($category)
    {
        $masterCodeId = ($category == 'TH')
            ? config('constants.options.ThanawiPapers')
            : config('constants.options.IdaadPapers');

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
            'level' => 'nullable|in:A,O'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? 'A';

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
        $level = $request->level ?? 'A';
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
        $level = $request->level ?? 'A';
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

    public function generateResultsPDF(Request $request)
    {
        try {
            $year = $request->year;
            $category = $request->category;
            $schoolNumber = $request->school_number;
            $level = $request->level;
            $schoolName = $request->school_name;
            $results = json_decode($request->results_data, true);

            // Calculate statistics for PDF
            $statistics = $this->calculateStatisticsTotal($results);

            // Prepare data for PDF view
            $data = [
                'year' => $year,
                'category' => $category,
                'schoolNumber' => $schoolNumber,
                'level' => $level,
                'schoolName' => $schoolName,
                'results' => $results,
                'statistics' => $statistics,
                'generated_date' => now()->format('F d, Y H:i:s'),
                'total_students' => count($results)
            ];

            // Load the PDF view
            $pdf = Pdf::loadView('itemGrading.pdf.grading-results', $data);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // Generate filename
            $filename = "Grading_Results_{$schoolName}_{$category}_{$year}_" . now()->format('Y-m-d') . ".pdf";

            // Download the PDF
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculateStatisticsTotal($results)
    {
        $count = count($results);
        $percentages = array_column($results, 'percentage');
        $totalPercentage = array_sum($percentages);

        // Grade distribution
        $gradeDistribution = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
            'F' => 0
        ];

        // Classification distribution
        $classDistribution = [
            'FIRST CLASS' => 0,
            'SECOND CLASS UPPER' => 0,
            'SECOND CLASS LOWER' => 0,
            'THIRD CLASS' => 0,
            'FAIL' => 0
        ];

        foreach ($results as $result) {
            $percentage = $result['percentage'];
            $classification = $result['classification'] ?? 'FAIL';

            // Grade distribution
            if ($percentage >= 80)
                $gradeDistribution['A']++;
            elseif ($percentage >= 70)
                $gradeDistribution['B']++;
            elseif ($percentage >= 60)
                $gradeDistribution['C']++;
            elseif ($percentage >= 50)
                $gradeDistribution['D']++;
            else
                $gradeDistribution['F']++;

            // Classification distribution
            if (isset($classDistribution[$classification])) {
                $classDistribution[$classification]++;
            }
        }

        return [
            'count' => $count,
            'average' => $count > 0 ? round($totalPercentage / $count, 2) : 0,
            'highest' => $count > 0 ? max($percentages) : 0,
            'lowest' => $count > 0 ? min($percentages) : 0,
            'grade_distribution' => $gradeDistribution,
            'class_distribution' => $classDistribution
        ];
    }

    public function exportAllPasswordsPDF(Request $request)
    {

        try {
            // Fetch all passwords with school information
            $passwords = SchoolPassword::with('school')
                ->orderBy('school_id')
                ->get()
                ->map(function ($item, $index) {
                    return [
                        'sr_no' => $index + 1,
                        'id' => $item->id,
                        'school_id' => $item->school_id,
                        'school_name' => $item->school
                            ? $item->school->House
                            : 'N/A',
                        'password_plain' => $item->password_plain,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d') : 'N/A',
                    ];
                });

            if ($passwords->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No passwords found to export'
                ], 404);
            }

            $data = [
                'passwords' => $passwords,
                'total_records' => count($passwords),
                'export_date' => now()->format('Y-m-d H:i:s'),
                'exported_by' => auth()->user()->name ?? 'System',
                'title' => 'School Passwords Export',
                'company_name' => 'ITEB ACADEMICS'
            ];

            // Clean any output buffers
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            // Generate PDF
            $pdf = Pdf::loadView('itemGrading.pdf.school-passwords', $data);
            $pdf->setPaper('A4', 'landscape');

            // Set options for better compatibility
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false
            ]);

            $filename = 'school_passwords_' . date('Y-m-d_His') . '.pdf';

            // Return with proper headers
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($pdf->output()),
                'Cache-Control' => 'private, max-age=0, must-revalidate',
                'Pragma' => 'public'
            ]);

        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            Log::error('PDF Export Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method for school to view registration form
    public function schoolStudentRegistration()
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return redirect()->route('School.login')->with('error', 'Please login first');
        }

        $school = House::find($schoolId);

        if (!$school) {
            return redirect()->back()->with('error', 'School not found');
        }

        // Get years from academic_years table using the Helper function
        $years = Helper::academicYears();

        // Get the active year or latest year as default
        $activeYear = AcademicYear::where('status', 'Active')->first();
        $currentYear = $activeYear ? $activeYear->year_en : date('Y');

        // Generate the next student ID for this school
        $lastNumber = DB::table('students_basic')
            ->where('Student_ID', 'LIKE', $school->Number . '-%-%-' . $currentYear)
            ->selectRaw("
            MAX(
                CAST(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(Student_ID, '-', 4),
                        '-', 
                        -1
                    ) AS UNSIGNED
                )
            ) as max_number
        ")
            ->value('max_number');

        $newNumber = str_pad(($lastNumber ?? 0) + 1, 3, '0', STR_PAD_LEFT);

        return view('School.register-student', compact('school', 'years', 'currentYear', 'newNumber'));
    }

    // Method to generate student ID for school registration
    public function generateSchoolStudentID(Request $request)
    {
        $schoolId = session('LoggedSchool');
        $category = $request->category;
        $year = $request->year;

        if (!$schoolId || !$category || !$year) {
            return response()->json(['student_id' => ''], 200);
        }

        $school = DB::table('houses')->where('ID', $schoolId)->first();
        if (!$school) {
            return response()->json(['student_id' => ''], 200);
        }

        $schoolNumber = $school->Number;

        // Check both main table and registrations table for last number
        $lastMainNumber = DB::table('students_basic')
            ->where('Student_ID', 'LIKE', $schoolNumber . '-' . $category . '-%-' . $year)
            ->selectRaw("
            MAX(
                CAST(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(Student_ID, '-', 4),
                        '-', 
                        -1
                    ) AS UNSIGNED
                )
            ) as max_number
        ")
            ->value('max_number');

        $lastRegNumber = DB::table('student_registrations')
            ->where('student_id', 'LIKE', $schoolNumber . '-' . $category . '-%-' . $year)
            ->where('admission_year', $year)
            ->selectRaw("
            MAX(
                CAST(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(student_id, '-', 4),
                        '-', 
                        -1
                    ) AS UNSIGNED
                )
            ) as max_number
        ")
            ->value('max_number');

        $lastNumber = max($lastMainNumber ?? 0, $lastRegNumber ?? 0);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $newStudentID = $schoolNumber . '-' . $category . '-' . $newNumber . '-' . $year;

        return response()->json(['student_id' => $newStudentID]);
    }

    // Method to store school registration
// Method to store school registration
    public function storeSchoolRegistration(Request $request)
    {
        $schoolId = session('LoggedSchool');
        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 1. Determine active year for slot/period checks
        $activeYear = AcademicYear::where('status', 'Active')->first();
        $checkYear = $activeYear ? $activeYear->year_en : date('Y');

        $existingSlot = SchoolRegistrationSlot::where('school_id', $schoolId)
            ->where('admission_year', $checkYear)
            ->first();

        // 2. Registration period check: global OR per-school override
        $globalOpen = RegistrationPeriod::globallyOpen();

        // Per-school flag: true = open override, false = explicitly closed for this school
        $schoolExplicitlyClosed = $existingSlot && $existingSlot->registration_open === false;
        $schoolExplicitlyOpen = $existingSlot && $existingSlot->registration_open === true;

        // Block if: global is closed AND school has no open override
        // Also block if: school is explicitly closed regardless of global status

        if ($schoolExplicitlyClosed) {
            return response()->json([
                'message' => 'Registration has been closed for your school by the admin.'
            ], 403);
        }

        if (!$globalOpen && !$schoolExplicitlyOpen) {
            return response()->json([
                'message' => 'Registration is currently closed globally. Contact the admin.'
            ], 403);
        }

        $validated = $request->validate([
            'category' => 'required|string|max:10',
            'admission_year' => 'required|integer',
            'student_id' => 'required|string|max:25|unique:student_registrations,student_id|unique:students_basic,Student_ID',
            'student_name' => 'required|string|max:100',
            'student_name_ar' => 'nullable|string|max:45',
            'date_of_birth' => 'nullable|date',
            'student_sex' => 'required|string|in:Male,Female',
            'student_nationality' => 'nullable|string|max:45',
            'birth_place' => 'nullable|string|max:100',
            'birth_place_ar' => 'nullable|string|max:100',
            'class' => 'nullable|string|max:45',
            'section' => 'nullable|string|max:45',
            'district' => 'nullable|string|max:45',
            'district_ar' => 'nullable|string|max:45',
        ]);

        // 3. Slot allocation check
        $slot = SchoolRegistrationSlot::where('school_id', $schoolId)
            ->where('admission_year', $validated['admission_year'])
            ->first();

        if (!$slot || $slot->slots_allocated <= 0) {
            return response()->json([
                'message' => 'No registration slots have been allocated for your school for ' . $validated['admission_year'] . '. Please contact the admin.'
            ], 403);
        }

        $slot->syncUsed();

        if ($slot->slotsRemaining() <= 0) {
            return response()->json([
                'message' => 'All ' . $slot->slots_allocated . ' allocated slots have been used. Contact the admin to request more.'
            ], 403);
        }

        $school = House::find($schoolId);

        try {
            $registration = StudentRegistration::create([
                'school_id' => $schoolId,
                'category' => $validated['category'],
                'admission_year' => $validated['admission_year'],
                'student_id' => $validated['student_id'],
                'student_name' => $validated['student_name'],
                'student_name_ar' => $validated['student_name_ar'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'student_sex' => $validated['student_sex'],
                'student_nationality' => $validated['student_nationality'] ?? null,
                'birth_place' => $validated['birth_place'] ?? null,
                'birth_place_ar' => $validated['birth_place_ar'] ?? null,
                'class' => $validated['class'] ?? null,
                'section' => $validated['section'] ?? null,
                'house' => $school ? $school->House : null,
                'district' => $validated['district'] ?? null,
                'district_ar' => $validated['district_ar'] ?? null,
                'entry_date' => now(),
                'status' => 'Pending Photo Submission',
                'is_locked' => false,
            ]);

            $slot->slots_used += 1;
            $slot->save();

            return response()->json([
                'message' => 'Student registered successfully!',
                'registration_id' => $registration->id,
                'student_id' => $registration->student_id,
                'slots_remaining' => $slot->slotsRemaining(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method to get recent registrations for the logged-in school
    public function getRecentRegistrations()
    {
        $schoolId = session('LoggedSchool');
        if (!$schoolId) {
            return response()->json(['registrations' => [], 'slot' => null], 200);
        }

        // Get all registrations for this school
        $registrations = StudentRegistration::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Slot info for the active year
        $activeYear = AcademicYear::where('status', 'Active')->first();
        $year = $activeYear ? $activeYear->year_en : date('Y');
        $slot = SchoolRegistrationSlot::where('school_id', $schoolId)
            ->where('admission_year', $year)
            ->first();

        $slotInfo = $slot ? [
            'slots_allocated' => $slot->slots_allocated,
            'slots_used' => $slot->slots_used,
            'slots_remaining' => $slot->slotsRemaining(),
            'registration_open' => $slot->registration_open,
        ] : null;

        // Check if global registration period is open
        $periodOpen = RegistrationPeriod::globallyOpen();

        return response()->json([
            'registrations' => $registrations,
            'slot' => $slotInfo,
            'global_open' => $periodOpen,
        ]);
    }

    public function deleteRegistration(Request $request)
    {
        $request->validate([
            'student_id' => 'required'
        ]);

        $deleted = StudentRegistration::where('student_id', $request->student_id)->first();

        if (!$deleted) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $deleted->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
            'student_id' => $request->student_id
        ]);
    }

    public function getRegistration(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $registration = StudentRegistration::where('id', $request->id)
            ->where('student_id', $request->student_id)
            ->where('school_id', $schoolId)
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        return response()->json(['registration' => $registration]);
    }

    public function updateRegistration(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'id' => 'required|integer',
            'student_id' => 'required|string|max:25',
            'category' => 'required|string|max:10',
            'admission_year' => 'required|integer',
            'student_name' => 'required|string|max:100',
            'student_name_ar' => 'nullable|string|max:45',
            'date_of_birth' => 'nullable|date',
            'student_sex' => 'required|string|in:Male,Female',
            'student_nationality' => 'nullable|string|max:45',
            'birth_place' => 'nullable|string|max:100',
            'birth_place_ar' => 'nullable|string|max:100',
            'class' => 'nullable|string|max:45',
            'section' => 'nullable|string|max:45',
            'district' => 'nullable|string|max:45',
            'district_ar' => 'nullable|string|max:45',
        ]);

        try {
            $registration = StudentRegistration::where('id', $validated['id'])
                ->where('school_id', $schoolId)
                ->first();

            if (!$registration) {
                return response()->json(['message' => 'Registration not found'], 404);
            }

            if ($registration->is_locked) {
                return response()->json([
                    'message' => 'This student record is locked after submission. Contact admin to make changes.'
                ], 403);
            }

            $registration->update([
                'category' => $validated['category'],
                'admission_year' => $validated['admission_year'],
                'student_name' => $validated['student_name'],
                'student_name_ar' => $validated['student_name_ar'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'student_sex' => $validated['student_sex'],
                'student_nationality' => $validated['student_nationality'] ?? null,
                'birth_place' => $validated['birth_place'] ?? null,
                'birth_place_ar' => $validated['birth_place_ar'] ?? null,
                'class' => $validated['class'] ?? null,
                'section' => $validated['section'] ?? null,
                'district' => $validated['district'] ?? null,
                'district_ar' => $validated['district_ar'] ?? null,
            ]);

            return response()->json([
                'message' => 'Student registration updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadRegistrationPhoto(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'student_id' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $registration = StudentRegistration::where('student_id', $request->student_id)
            ->where('school_id', $schoolId)
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $path = public_path('assets/student_photos');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $oldImage = $path . '/' . $request->student_id . '.jpg';
        if (\Illuminate\Support\Facades\File::exists($oldImage)) {
            \Illuminate\Support\Facades\File::delete($oldImage);
        }

        $request->file('photo')->move($path, $request->student_id . '.jpg');

        // Update status since photo is now available
        $registration->status = 'Attached Image, Pending Submission';
        $registration->save();

        return response()->json([
            'message' => 'Photo uploaded successfully',
            'status' => $registration->status,
        ]);
    }

    public function removeRegistrationPhoto(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate(['student_id' => 'required|string']);

        $registration = StudentRegistration::where('student_id', $request->student_id)
            ->where('school_id', $schoolId)
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $image = public_path('assets/student_photos/' . $request->student_id . '.jpg');
        if (\Illuminate\Support\Facades\File::exists($image)) {
            \Illuminate\Support\Facades\File::delete($image);
        }

        $registration->status = 'Pending Photo Submission';
        $registration->save();

        return response()->json(['message' => 'Photo removed successfully']);
    }

    // Add these methods to your SchoolsController.php file, before the closing brace of the class

    public function step3Students(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['students' => [], 'debug' => 'no session'], 200);
        }

        $year = (int) $request->year;
        $category = trim($request->category);

        $students = StudentRegistration::where('school_id', (string) $schoolId)
            ->whereIn('status', [
                'Attached Image, Pending Submission',
                'Returned'
            ])
            ->where('admission_year', $year)
            ->where('category', $category)
            ->get();

        return response()->json([
            'students' => $students,
            'debug' => [
                'school_id' => (string) $schoolId,
                'year' => $year,
                'category' => $category,
                'count' => $students->count(),
            ]
        ]);
    }


    public function step3Submit(Request $request)
    {
        $schoolId = session('LoggedSchool');

        if (!$schoolId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ids = json_decode($request->ids, true);

        if (empty($ids)) {
            return response()->json(['message' => 'No students selected.'], 422);
        }

        $submissionDocument = null;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();

            // Generate unique filename
            $fileName = 'submission_' . time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $file->move(public_path('submission_docs'), $fileName);

            // Save document record
            $submissionDocument = SubmissionDocument::create([
                'submission_batch_id' => null,
                'file_name' => $originalName,
                'file_path' => 'submission_docs/' . $fileName,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'student_ids' => json_encode($ids),
                'school_id' => $schoolId,
            ]);
        }

        // Update student statuses and lock records
        StudentRegistration::whereIn('id', $ids)
            ->where('school_id', $schoolId)
            ->whereIn('status', [
                'Attached Image, Pending Submission',
                'Returned'
            ])
            ->update([
                'status' => 'Pending Admin Approval',
                'is_locked' => true,
                'submitted_at' => now(),
                'submission_document_id' => $submissionDocument ? $submissionDocument->id : null
            ]);

        return response()->json([
            'message' => count($ids) . ' student(s) submitted for admin approval successfully.',
            'document' => $submissionDocument
        ]);
    }


    public function adminStudentApprovals()
    {
        $allRegistrations = StudentRegistration::select('school_id', 'admission_year')
            ->distinct()
            ->get();

        $schools = [];
        $seen = [];

        foreach ($allRegistrations as $row) {
            $key = $row->school_id . '_' . $row->admission_year;
            if (in_array($key, $seen))
                continue;
            $seen[] = $key;

            $sid = $row->school_id;
            $year = $row->admission_year;

            $pending = StudentRegistration::where('school_id', $sid)->where('admission_year', $year)->where('status', 'Pending Admin Approval')->count();
            $approved = StudentRegistration::where('school_id', $sid)->where('admission_year', $year)->where('status', 'Approved')->count();
            $total = StudentRegistration::where('school_id', $sid)->where('admission_year', $year)->count();

            $slot = SchoolRegistrationSlot::where('school_id', $sid)->where('admission_year', $year)->first();

            $firstReg = StudentRegistration::where('school_id', $sid)->where('admission_year', $year)->first();
            $parts = $firstReg ? explode('-', $firstReg->student_id) : [];
            $prefix = count($parts) >= 2 ? $parts[0] . '-' . $parts[1] : (string) $sid;

            $schools[] = [
                'prefix' => $prefix,
                'school_id' => $sid,
                'admission_year' => $year,
                'school_name' => Helper::schoolNameByID($sid) ?? $prefix,
                'pending_count' => $pending,
                'approved_count' => $approved,
                'total_registered' => $total,
                'slots_allocated' => $slot ? $slot->slots_allocated : 0,
                'slots_used' => $slot ? $slot->slots_used : 0,
                'slots_remaining' => $slot ? $slot->slotsRemaining() : 0,
                'school_reg_open' => $slot ? $slot->registration_open : false,
                'latest_submission' => StudentRegistration::where('school_id', $sid)->where('admission_year', $year)->max('updated_at'),
            ];
        }

        usort($schools, fn($a, $b) => $b['pending_count'] <=> $a['pending_count']);

        $globalPeriod = RegistrationPeriod::active();
        $globalOpen = RegistrationPeriod::globallyOpen();
        $activeYear = AcademicYear::where('status', 'Active')->first();
        $allSchools = House::orderBy('House')->get();

        return view('School.admin-approvals', compact(
            'schools',
            'globalPeriod',
            'globalOpen',
            'activeYear',
            'allSchools'
        ));
    }

    public function adminSchoolApprovalDetail($schoolPrefix)
    {
        $registrations = StudentRegistration::where('student_id', 'LIKE', $schoolPrefix . '-%')
            ->orderBy('student_id')
            ->get();

        $schoolId = $registrations->first()->school_id ?? null;
        $schoolName = $schoolId ? (Helper::schoolNameByID($schoolId) ?? $schoolPrefix) : $schoolPrefix;

        $slot = $schoolId
            ? SchoolRegistrationSlot::where('school_id', $schoolId)->orderByDesc('admission_year')->first()
            : null;

        return view('School.admin-approval-detail', compact('registrations', 'schoolPrefix', 'schoolName', 'slot'));
    }

    public function adminUpdateApprovalStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
            'action' => 'required|in:Approved,Rejected',
        ]);

        $ids = json_decode($request->ids, true);
        $action = $request->action;

        if (empty($ids)) {
            return response()->json(['message' => 'No students selected.'], 422);
        }

        $registrations = StudentRegistration::whereIn('id', $ids)
            ->where('status', 'Pending Admin Approval')
            ->get();

        if ($registrations->isEmpty()) {
            return response()->json(['message' => 'No matching records found.'], 404);
        }

        $approved = 0;
        $rejected = 0;
        $errors = [];

        foreach ($registrations as $reg) {
            if ($action === 'Approved') {
                // Remove existing record first so we always re-insert the latest approved data
                DB::table('students_basic')->where('Student_ID', $reg->student_id)->delete();

                $category = $reg->category;
                $class = $category === 'ID' ? 'Senior Four' : 'Senior Six';
                $classAR = $category === 'ID' ? 'الإعدادية' : 'الثانوي';

                DB::table('students_basic')->insert([
                    'Student_ID' => $reg->student_id,
                    'Student_Name' => $reg->student_name,
                    'Student_Name_AR' => $reg->student_name_ar,
                    'Date_of_Birth' => $reg->date_of_birth,
                    'StudentSex' => $reg->student_sex,
                    'StudentsNationality' => $reg->student_nationality,
                    'House' => $reg->house,
                    'admnyr' => $reg->admission_year,
                    'EntryDate' => now(),
                    'Section' => $reg->section ?? 'Day',
                    'Class' => $class,
                    'Class_AR' => $classAR,
                    'state' => 'Active',
                    'Birth_Place' => $reg->birth_place,
                    'Birth_Place_AR' => $reg->birth_place_ar,
                    'District' => $reg->district,
                    'District_AR' => $reg->district_ar,
                ]);

                // DB::table('class_allocations')->insert([
                //     'Student_ID' => $reg->student_id,
                //     'Class_ID' => 1,
                // ]);

                $reg->status = 'Approved';
                $reg->save();
                $approved++;

            } else {
                $reg->status = 'Returned';
                $reg->is_locked = false;
                $reg->save();
                $rejected++;
            }
        }

        return response()->json([
            'message' => "$approved approved, $rejected returned.",
            'errors' => $errors,
            'approved' => $approved,
            'rejected' => $rejected,
        ]);
    }


    // =========================================================
    // SLOT MANAGEMENT METHODS
    // =========================================================

    public function adminSearchSchoolsForSlots(Request $request)
    {
        $q = trim($request->input('q', ''));

        $schools = House::when($q, function ($query) use ($q) {
            $query->where('House', 'LIKE', "%{$q}%")
                ->orWhere('Number', 'LIKE', "%{$q}%");
        })
            ->orderBy('House')
            ->limit(25)
            ->get(['ID', 'House', 'Number', 'Location']);

        $activeYear = AcademicYear::where('status', 'Active')->first();
        $year = $activeYear ? (int) $activeYear->year_en : (int) date('Y');

        $schools = $schools->map(function ($school) use ($year) {
            $slot = SchoolRegistrationSlot::where('school_id', $school->ID)
                ->where('admission_year', $year)
                ->first();

            $school->slot = $slot ? [
                'id' => $slot->id,
                'slots_allocated' => $slot->slots_allocated,
                'slots_used' => $slot->slots_used,
                'slots_remaining' => $slot->slotsRemaining(),
                'registration_open' => (bool) $slot->registration_open,
            ] : null;

            return $school;
        });

        return response()->json(['schools' => $schools, 'year' => $year]);
    }

    public function adminAssignSlots(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'admission_year' => 'required|integer',
            'slots' => 'required|integer|min:1|max:1000',
            'reason' => 'nullable|string|max:255',
        ]);

        $adminId = session('LoggedAdmin') ?? session('LoggedStudent');

        $slot = SchoolRegistrationSlot::firstOrCreate(
            ['school_id' => $request->school_id, 'admission_year' => (int) $request->admission_year],
            ['slots_allocated' => 0, 'slots_used' => 0, 'registration_open' => true, 'allocated_by' => $adminId]
        );

        $slot->syncUsed();
        $slot->slots_allocated += (int) $request->slots;
        $slot->registration_open = true;
        $slot->allocated_by = $adminId;
        $slot->save();

        SchoolSlotHistory::create([
            'school_id' => $request->school_id,
            'admission_year' => (int) $request->admission_year,
            'slots_added' => (int) $request->slots,
            'total_after' => $slot->slots_allocated,
            'reason' => $request->reason,
            'added_by' => $adminId,
        ]);

        return response()->json([
            'message' => $request->slots . ' slot(s) added successfully.',
            'slots_allocated' => $slot->slots_allocated,
            'slots_used' => $slot->slots_used,
            'slots_remaining' => $slot->slotsRemaining(),
        ]);
    }

    public function adminToggleSchoolRegistration(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'admission_year' => 'required|integer',
            'open' => 'required|boolean',
        ]);

        $slot = SchoolRegistrationSlot::firstOrCreate(
            ['school_id' => $request->school_id, 'admission_year' => (int) $request->admission_year],
            ['slots_allocated' => 0, 'slots_used' => 0, 'registration_open' => false]
        );

        $slot->registration_open = (bool) $request->open;
        $slot->save();

        $status = $slot->registration_open ? 'opened' : 'closed';

        return response()->json([
            'message' => "Registration {$status} for this school.",
            'registration_open' => $slot->registration_open,
        ]);
    }

    public function adminSlotHistory(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'admission_year' => 'required|integer',
        ]);

        $history = SchoolSlotHistory::where('school_id', $request->school_id)
            ->where('admission_year', (int) $request->admission_year)
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['history' => $history]);
    }

    // =========================================================
    // GLOBAL REGISTRATION PERIOD METHODS
    // =========================================================

    public function adminSaveRegistrationPeriod(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'admission_year' => 'required|integer',
            'opens_at' => 'nullable|date',
            'closes_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $adminId = session('LoggedAdmin') ?? session('LoggedStudent');

        try {
            if ($request->is_active) {
                RegistrationPeriod::where('is_active', true)->update(['is_active' => false]);
            }

            $period = RegistrationPeriod::create([
                'name' => $request->name,
                'admission_year' => (int) $request->admission_year,
                'opens_at' => $request->opens_at ?: null,
                'closes_at' => $request->closes_at ?: null,
                'is_active' => (bool) $request->is_active,
                'created_by' => $adminId,
            ]);

            return response()->json([
                'message' => 'Registration period saved' . ($request->is_active ? ' and activated.' : '.'),
                'period' => $period,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function adminUpdateRegistrationPeriod(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'admission_year' => 'nullable|integer',
            'opens_at' => 'nullable|date',
            'closes_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $period = RegistrationPeriod::findOrFail($id);

        if ($request->is_active && !$period->is_active) {
            RegistrationPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        $period->update([
            'name' => $request->name ?: $period->name,
            'admission_year' => $request->admission_year ?: $period->admission_year,
            'opens_at' => $request->opens_at ?: null,
            'closes_at' => $request->closes_at ?: null,
            'is_active' => (bool) $request->is_active,
        ]);

        return response()->json(['message' => 'Period updated.', 'period' => $period]);
    }

    public function adminDeleteRegistrationPeriod($id)
    {
        RegistrationPeriod::findOrFail($id)->delete();
        return response()->json(['message' => 'Period deleted.']);
    }

    // Admin: Toggle lock status on a single student registration
    public function adminToggleStudentLock(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'lock' => 'required|boolean',
        ]);

        $reg = StudentRegistration::findOrFail($request->id);
        $reg->is_locked = (bool) $request->lock;

        // If unlocking, revert status so school can edit and resubmit
        if (!$reg->is_locked && $reg->status === 'Pending Admin Approval') {
            $reg->status = 'Attached Image, Pending Submission';
            $reg->submitted_at = null;
        }

        $reg->save();

        return response()->json([
            'message' => $reg->is_locked ? 'Student locked.' : 'Student unlocked — school can now edit and resubmit.',
            'is_locked' => $reg->is_locked,
            'status' => $reg->status,
        ]);
    }
}
