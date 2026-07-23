<?php

namespace App\Services;

use App\Models\ClassAllocation;
use App\Models\GradingSetting;
use App\Models\Mark;
use App\Models\MasterData;
use App\Models\StudentSubjectRegistration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Shared data-gathering logic for the Reports module (mock passlips,
 * subject slips, and analysed reports). Kept in one place so the grade
 * calculation rules never drift between the three report types.
 */
class ReportDataService
{
    public const ABSENT_MARK = 'X';

    /**
     * Master data code id for a category (UCE/UACE/PLE).
     */
    public function masterCodeId(string $category): int
    {
        return match ($category) {
            'UACE' => (int) config('constants.options.UACEPapers'),
            'PLE' => (int) config('constants.options.PLEPapers'),
            default => (int) config('constants.options.UCEPapers'),
        };
    }

    /**
     * All students belonging to a school/category/year, ordered by their
     * Student_ID (which carries the sequence number, e.g. ...-004-2026).
     */
    public function studentsFor(string $category, string $year, string $schoolNumber): Collection
    {
        return ClassAllocation::where('Student_ID', 'LIKE', "{$schoolNumber}-{$category}-%")
            ->where('Student_ID', 'LIKE', "%-{$year}")
            ->orderBy('Student_ID')
            ->pluck('Student_ID');
    }

    /**
     * Student list for the report-filter "Student" picker, with names
     * batch-loaded in a single query (not N+1 — one query per student would
     * be slow for 500+ students). Optional $query/$limit let a caller do
     * server-side filtering later if ever needed; the current UI fetches
     * the full list once per school selection and filters client-side.
     */
    public function studentsForSchoolSearch(string $category, string $year, string $schoolNumber, ?string $query = null, int $limit = 100000): array
    {
        $studentIds = $this->studentsFor($category, $year, $schoolNumber);

        $names = DB::table('students_basic')
            ->whereIn('Student_ID', $studentIds)
            ->pluck('Student_Name', 'Student_ID');

        $students = $studentIds->map(fn (string $id) => [
            'id' => $id,
            'name' => $names[$id] ?? '—',
        ]);

        $query = trim((string) $query);
        if ($query !== '') {
            $needle = strtolower($query);
            $students = $students->filter(
                fn (array $s) => str_contains(strtolower($s['id']), $needle)
                    || str_contains(strtolower($s['name']), $needle)
            )->values();
        }

        return [
            'total' => $students->count(),
            'results' => $students->take($limit)->values(),
        ];
    }

    /**
     * The ordered subject list for a single student: compulsory subjects
     * first, then whichever optional subjects that student is registered
     * for — matching exactly what subject-registration/manage shows for
     * that student.
     */
    public function subjectsForStudent(string $category, string $studentId, string $year, string $schoolNumber): Collection
    {
        $masterCodeId = $this->masterCodeId($category);

        $compulsory = MasterData::where('md_master_code_id', $masterCodeId)
            ->where('md_misc1', 'Compulsory')
            ->orderBy('md_id')
            ->get();

        $registeredOptionalIds = StudentSubjectRegistration::where('student_id', $studentId)
            ->where('year', $year)
            ->where('is_compulsory', false)
            ->pluck('subject_id');

        $optional = MasterData::where('md_master_code_id', $masterCodeId)
            ->whereIn('md_id', $registeredOptionalIds)
            ->orderBy('md_id')
            ->get();

        return $compulsory->concat($optional);
    }

    /**
     * The full subject list for a category (compulsory + every optional
     * subject that exists), used for school-wide reports (subjectslip,
     * analysed report) where every column must be shown regardless of who
     * sat it.
     */
    public function allSubjectsForCategory(string $category): Collection
    {
        return MasterData::where('md_master_code_id', $this->masterCodeId($category))
            ->orderBy('md_id')
            ->get();
    }

    /**
     * Raw mark for a student/subject, or null if never uploaded.
     */
    public function markFor(string $studentId, int $subjectId, string $year): ?float
    {
        $mark = Mark::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('year', $year)
            ->value('mark');

        return $mark === null ? null : (float) $mark;
    }

    /**
     * Resolve a raw mark into ['grade' => 'C6', 'points' => 6] using the
     * category's configured grading_settings (Marks type). Points are
     * parsed out of the grade's comment (e.g. "Distinction (6 pts)"); if a
     * category's grading comments don't carry that convention, points fall
     * back to a simple descending count so a total can still be produced.
     */
    public function resolveGrade(string $category, ?float $mark): array
    {
        if ($mark === null) {
            return ['grade' => self::ABSENT_MARK, 'points' => null];
        }

        $row = GradingSetting::getGrade($mark, 'Marks', $category);

        if (!$row) {
            return ['grade' => '-', 'points' => null];
        }

        $points = null;
        if (preg_match('/(\d+)\s*pts?/i', (string) $row->comment, $m)) {
            $points = (int) $m[1];
        } else {
            $totalGrades = GradingSetting::where('category', $category)->where('type', 'Marks')->count();
            $points = max(0, $totalGrades - (int) $row->sort_order);
        }

        return ['grade' => $row->grade, 'points' => $points];
    }

    /**
     * The ordered list of distinct grade letters configured for a category
     * (e.g. A,B,C,D,E,O,F for UACE or A,B,C,D,E for UCE) — drives the
     * subjectslip column headings dynamically instead of hardcoding a
     * fixed grading scale.
     */
    public function gradeScale(string $category): Collection
    {
        return GradingSetting::where('category', $category)
            ->where('type', 'Marks')
            ->orderBy('sort_order')
            ->orderBy('weight')
            ->pluck('grade');
    }

    public function hasFailGrade(string $category): bool
    {
        return $this->gradeScale($category)->contains(function ($g) {
            return str_starts_with(strtoupper((string) $g), 'F');
        });
    }

    /**
     * Build the full per-subject row (grade + points) for one student,
     * across the subjects that student is actually registered for.
     *
     * Returns a collection of ['subject' => MasterData, 'mark' => ?float,
     * 'grade' => string, 'points' => ?int].
     */
    public function studentSubjectResults(string $category, string $studentId, string $year, string $schoolNumber): Collection
    {
        return $this->subjectsForStudent($category, $studentId, $year, $schoolNumber)
            ->map(function (MasterData $subject) use ($category, $studentId, $year) {
                $mark = $this->markFor($studentId, $subject->md_id, $year);
                $resolved = $this->resolveGrade($category, $mark);

                return [
                    'subject' => $subject,
                    'mark' => $mark,
                    'grade' => $resolved['grade'],
                    'points' => $resolved['points'],
                ];
            });
    }

    public function totalPoints(Collection $subjectResults): int
    {
        return (int) $subjectResults->sum('points');
    }

    public function studentName(string $studentId): string
    {
        return DB::table('students_basic')->where('Student_ID', $studentId)->value('Student_Name') ?? '—';
    }

    public function schoolNameByNumber(string $schoolNumber): string
    {
        return DB::table('houses')->where('Number', $schoolNumber)->value('House') ?? $schoolNumber;
    }

    public function schoolDistrictByNumber(string $schoolNumber): string
    {
        return DB::table('houses')->where('Number', $schoolNumber)->value('district') ?? 'NA';
    }
}