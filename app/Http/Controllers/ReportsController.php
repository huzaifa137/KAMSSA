<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Services\CombinationService;
use App\Services\ReportDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct(protected ReportDataService $reports, protected CombinationService $combinations)
    {
    }

    /**
     * The cards dashboard. $portal is 'bureau' or 'school' — controls
     * whether the school picker is shown (bureau side) or locked to the
     * logged-in school (school portal side), and which route names the
     * cards submit to.
     */
    public function dashboard(Request $request, string $portal = 'bureau')
    {
        $schools = $portal === 'bureau'
            ? House::orderBy('House')->get(['Number', 'House'])
            : collect();

        $lockedSchoolNumber = null;
        if ($portal === 'school') {
            $school = House::find(session('LoggedSchool'));
            $lockedSchoolNumber = $school->Number ?? null;
        }

        $years = DB::table('class_allocation')
            ->selectRaw("DISTINCT SUBSTRING_INDEX(Student_ID, '-', -1) as year")
            ->orderByDesc('year')
            ->pluck('year');

        return view('reports.dashboard', [
            'portal' => $portal,
            'schools' => $schools,
            'lockedSchoolNumber' => $lockedSchoolNumber,
            'years' => $years,
        ]);
    }

    /**
     * For school-portal report requests, the school_number is never taken
     * from user input — it's forced to the logged-in school so a school
     * can never pull another school's reports.
     */
    protected function lockToLoggedInSchool(Request $request): void
    {
        $school = House::find(session('LoggedSchool'));
        if ($school) {
            $request->merge(['school_number' => $school->Number]);
        }
    }

    protected function validateFilters(Request $request, bool $requireStudent = false): array
    {
        $rules = [
            'category' => 'required|in:UCE,UACE,PLE',
            'year' => 'required|string',
            'school_number' => 'required|string',
        ];

        if ($requireStudent) {
            $rules['student_id'] = 'nullable|string';
        }

        return $request->validate($rules);
    }

    /**
     * Mock Passlip — student-wise. Either the whole school (default) or a
     * single student_id. Three slips are laid out per A4 page.
     */
    public function mockPasslip(Request $request)
    {
        $f = $this->validateFilters($request, true);

        $studentIds = !empty($f['student_id'])
            ? collect([$f['student_id']])
            : $this->reports->studentsFor($f['category'], $f['year'], $f['school_number']);

        $slips = $studentIds->map(function (string $studentId) use ($f) {
            $results = $this->reports->studentSubjectResults($f['category'], $studentId, $f['year'], $f['school_number']);

            return [
                'student_id' => $studentId,
                'name' => $this->reports->studentName($studentId),
                'school' => $this->reports->schoolNameByNumber($f['school_number']),
                'district' => $this->reports->schoolDistrictByNumber($f['school_number']),
                'combination_code' => $f['category'] === 'UACE' ? $this->combinations->codeForStudent($studentId, $f['year']) : null,
                'results' => $results,
                'total_points' => $f['category'] === 'UACE' ? $this->reports->totalPoints($results) : null,
            ];
        });

        return view('reports.mock-passlip', [
            'category' => $f['category'],
            'year' => $f['year'],
            'slips' => $slips,
            'chunks' => $slips->chunk(3),
        ]);
    }

    /**
     * Mock Subjectslip — school-wide, per-subject grade distribution.
     */
    public function mockSubjectSlip(Request $request)
    {
        $f = $this->validateFilters($request);

        $studentIds = $this->reports->studentsFor($f['category'], $f['year'], $f['school_number']);
        $subjects = $this->reports->allSubjectsForCategory($f['category']);
        $gradeScale = $this->reports->gradeScale($f['category']);
        $showPassColumn = $this->reports->hasFailGrade($f['category']);

        $rows = $subjects->map(function ($subject) use ($studentIds, $f, $gradeScale, $showPassColumn) {
            // Plain array, not a Collection — Collection's ArrayAccess::offsetGet()
            // doesn't return by reference, so $tally[$grade]++ below would fail
            // with "Indirect modification of overloaded element ... has no effect".
            $tally = $gradeScale->mapWithKeys(fn($g) => [$g => 0])->all();
            $sat = 0;
            $failed = 0;

            foreach ($studentIds as $studentId) {
                $mark = $this->reports->markFor($studentId, $subject->md_id, $f['year']);
                if ($mark === null) {
                    continue; // student didn't sit this subject at all
                }

                $resolved = $this->reports->resolveGrade($f['category'], $mark);
                if (array_key_exists($resolved['grade'], $tally)) {
                    $tally[$resolved['grade']]++;
                }
                $sat++;
                if (str_starts_with(strtoupper($resolved['grade']), 'F')) {
                    $failed++;
                }
            }

            return [
                'subject' => $subject,
                'tally' => $tally,
                'sat' => $sat,
                'percent_pass' => $sat > 0 ? round((($sat - $failed) / $sat) * 100, 2) : 0.00,
            ];
        })->filter(fn($row) => $row['sat'] > 0)->values();

        return view('reports.mock-subjectslip', [
            'category' => $f['category'],
            'year' => $f['year'],
            'schoolNumber' => $f['school_number'],
            'schoolName' => $this->reports->schoolNameByNumber($f['school_number']),
            'schoolDistrict' => $this->reports->schoolDistrictByNumber($f['school_number']),
            'gradeScale' => $gradeScale,
            'showPassColumn' => $showPassColumn,
            'rows' => $rows,
        ]);
    }

    /**
     * Mock Analysed Report — school-wide grid of every student against
     * every subject in the category.
     */
    public function mockAnalysed(Request $request)
    {
        $f = $this->validateFilters($request);

        $studentIds = $this->reports->studentsFor($f['category'], $f['year'], $f['school_number']);
        $subjects = $this->reports->allSubjectsForCategory($f['category']);

        $students = $studentIds->map(function (string $studentId) use ($subjects, $f) {
            $grades = [];
            $totalPoints = 0;

            foreach ($subjects as $subject) {
                $mark = $this->reports->markFor($studentId, $subject->md_id, $f['year']);
                $resolved = $this->reports->resolveGrade($f['category'], $mark);
                $grades[$subject->md_id] = $resolved['grade'];
                $totalPoints += $resolved['points'] ?? 0;
            }

            return [
                'student_id' => $studentId,
                'name' => $this->reports->studentName($studentId),
                'combination_code' => $f['category'] === 'UACE' ? $this->combinations->codeForStudent($studentId, $f['year']) : null,
                'grades' => $grades,
                'points' => $totalPoints,
            ];
        });

        return view('reports.mock-analysed', [
            'category' => $f['category'],
            'year' => $f['year'],
            'schoolNumber' => $f['school_number'],
            'schoolName' => $this->reports->schoolNameByNumber($f['school_number']),
            'schoolDistrict' => $this->reports->schoolDistrictByNumber($f['school_number']),
            'subjects' => $subjects,
            'students' => $students,
        ]);
    }

    /**
     * AJAX endpoint used by the report filter modal to populate the
     * "Student" picker once Category, Year and School are all chosen.
     * Returns the FULL list for that school as a plain JSON array of
     * { id, name } — the browser filters it client-side as the person
     * types, so this is one lightweight request per school selection
     * rather than one request per keystroke.
     */
    public function studentsForSchool(Request $request)
    {
        $f = $request->validate([
            'category' => 'required|in:UCE,UACE,PLE',
            'year' => 'required|string',
            'school_number' => 'required|string',
        ]);

        $data = $this->reports->studentsForSchoolSearch($f['category'], $f['year'], $f['school_number']);

        return response()->json(
            collect($data['results'])->map(fn (array $s) => [
                'id' => $s['id'],
                'name' => $s['name'],
            ])->values()
        );
    }

    // ---- School portal entry points (school_number locked server-side) ----

    public function schoolMockPasslip(Request $request)
    {
        $this->lockToLoggedInSchool($request);
        return $this->mockPasslip($request);
    }

    public function schoolMockSubjectSlip(Request $request)
    {
        $this->lockToLoggedInSchool($request);
        return $this->mockSubjectSlip($request);
    }

    public function schoolMockAnalysed(Request $request)
    {
        $this->lockToLoggedInSchool($request);
        return $this->mockAnalysed($request);
    }

    public function schoolStudentsForSchool(Request $request)
    {
        $this->lockToLoggedInSchool($request);
        return $this->studentsForSchool($request);
    }
}