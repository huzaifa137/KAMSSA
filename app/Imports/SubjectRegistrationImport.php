<?php

namespace App\Imports;

use App\Models\ClassAllocation;
use App\Models\MasterData;
use App\Models\StudentSubjectRegistration;
use App\Services\CombinationService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

/**
 * Reads the sheet produced by SubjectRegistrationTemplateExport and upserts
 * student_subject_registrations (UCE) or student_combinations + synced
 * student_subject_registrations (UACE) accordingly.
 *
 * UCE column layout:
 *   0: No
 *   1: Student_ID
 *   2: Student Name
 *   3...: one column per OPTIONAL subject header present in THIS sheet.
 *         Compulsory subjects are never columns — the export leaves them
 *         out, and the manage screen auto-registers them separately.
 *         Which optional subjects appear, and in what order, is read fresh
 *         from each file's own header row rather than assumed, since
 *         schools commonly delete columns for subjects they don't offer.
 *
 * UCE optional subjects are registered only when the cell contains a
 * recognisable "yes" marker (YES, Y, 1, X, TRUE); otherwise any existing
 * registration for that subject is removed.
 *
 * IMPORTANT — column position is NOT trusted for UCE. Schools routinely
 * delete the column for an optional subject they don't offer before
 * re-uploading (e.g. removing "CHRISTIAN RELIGIOUS EDUCATION [Optional]"
 * entirely), which shifts every column after it one to the left. Reading
 * by fixed index (3 + $i against a full, unfiltered subject list) would
 * then read, say, the LUGANDA answers into the CRE slot. Instead we read
 * the sheet's own header row on every import and resolve each column to a
 * subject by matching its header text against MasterData, so the mapping
 * is correct no matter which columns a particular school kept, removed,
 * or reordered.
 *
 * UACE column layout:
 *   0: No
 *   1: Student_ID
 *   2: Student Name
 *   3: Combination (a single combination code, e.g. PCM) — a UACE student
 *      sits one standardized combination rather than freely-mixed
 *      optional subjects, so there is one column instead of one per
 *      subject. CombinationService resolves the code and syncs
 *      student_subject_registrations to match automatically.
 */
class SubjectRegistrationImport implements ToCollection
{
    protected string $category;
    protected string $year;
    protected string $schoolNumber;
    protected Collection $subjects; // UCE only: all valid optional MasterData rows, keyed by normalised name
    protected CombinationService $combinations;

    protected array $imported = [];   // student_id => [subject names registered] (UCE) or combination code (UACE)
    protected array $skippedRows = []; // human-readable row errors
    protected int $studentsProcessed = 0;

    private const YES_MARKERS = ['YES', 'Y', '1', 'X', 'TRUE'];

    public function __construct(string $category, string $year, string $schoolNumber)
    {
        $this->category = $category;
        $this->year = $year;
        $this->schoolNumber = $schoolNumber;
        $this->combinations = app(CombinationService::class);

        if ($category === 'UACE') {
            $this->subjects = collect();
            return;
        }

        $masterCode = config('constants.options.UCEPapers');

        // Keyed by normalised subject name so header text can be resolved
        // back to the right MasterData row regardless of column position.
        $this->subjects = MasterData::where('md_master_code_id', $masterCode)
            ->where(function ($q) {
                $q->whereNull('md_misc2')->orWhere('md_misc2', '!=', 'Inactive');
            })
            ->where(function ($q) {
                $q->whereNull('md_misc1')->orWhere('md_misc1', '!=', 'Compulsory');
            })
            ->orderBy('md_name')
            ->get()
            ->keyBy(fn ($subject) => $this->normaliseHeader($subject->md_name));
    }

    /**
     * Strips the " [Optional]" suffix the template appends, and normalises
     * case/whitespace, so header text can be matched to a subject name
     * reliably regardless of minor formatting differences.
     */
    private function normaliseHeader(string $value): string
    {
        $value = trim($value);
        $value = preg_replace('/\s*\[optional\]\s*$/i', '', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return strtoupper(trim($value));
    }

    /**
     * Reads the header row and builds colIndex => MasterData subject,
     * skipping any column that isn't a recognised optional subject
     * (No / Student_ID / Student Name / stray columns).
     *
     * @return array<int, MasterData>
     */
    private function resolveColumnMap(Collection $headerRow): array
    {
        $map = [];

        foreach ($headerRow as $colIndex => $headerCell) {
            $header = $this->normaliseHeader((string) ($headerCell ?? ''));

            if ($header === '') {
                continue;
            }

            $subject = $this->subjects->get($header);

            if ($subject !== null) {
                $map[$colIndex] = $subject;
            }
        }

        return $map;
    }

    /**
     * Finds the "Combination" column by header text (not fixed position),
     * for the same resilience-to-reordering reason as resolveColumnMap().
     */
    private function resolveCombinationColumn(Collection $headerRow): ?int
    {
        foreach ($headerRow as $colIndex => $headerCell) {
            if ($this->normaliseHeader((string) ($headerCell ?? '')) === 'COMBINATION') {
                return $colIndex;
            }
        }

        return null;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            $this->skippedRows[] = 'The uploaded file has no data rows.';
            return;
        }

        if ($this->category === 'UACE') {
            $this->importUace($rows);
            return;
        }

        $this->importUce($rows);
    }

    private function importUce(Collection $rows): void
    {
        $columnMap = $this->resolveColumnMap($rows->first());

        if (empty($columnMap)) {
            $this->skippedRows[] = 'Could not match any subject columns in the header row — check that the subject column headers were not renamed.';
            return;
        }

        // First row is the heading row produced by the export — skip it.
        foreach ($rows->skip(1) as $index => $row) {
            $excelRow = $index + 2; // account for header + 0-based skip

            $studentId = trim((string) ($row[1] ?? ''));

            if ($studentId === '') {
                continue; // blank row, ignore silently
            }

            if (!$this->belongsHere($studentId)) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' is not a {$this->category} student of school {$this->schoolNumber} for {$this->year} — skipped.";
                continue;
            }

            $registeredNames = [];
            $anyCellAnswered = false; // true once any cell has an explicit YES or NO in it

            foreach ($columnMap as $colIndex => $subject) {
                $cell = strtoupper(trim((string) ($row[$colIndex] ?? '')));
                $isMarked = in_array($cell, self::YES_MARKERS, true);

                if ($cell !== '') {
                    $anyCellAnswered = true;
                }

                if ($isMarked) {
                    StudentSubjectRegistration::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'subject_id' => $subject->md_id,
                            'year' => $this->year,
                        ],
                        [
                            'category' => $this->category,
                            'is_compulsory' => false,
                            'school_number' => $this->schoolNumber,
                        ]
                    );
                    $registeredNames[] = $subject->md_name;
                } else {
                    // Explicit "NO", or left blank — either way, make sure
                    // any previous registration for this optional subject
                    // is removed.
                    StudentSubjectRegistration::where('student_id', $studentId)
                        ->where('subject_id', $subject->md_id)
                        ->where('year', $this->year)
                        ->delete();
                }
            }

            // Only flag as skipped when the row genuinely has no answers at
            // all (every optional cell left blank) — a student explicitly
            // marked NO on every optional subject is a valid, intentional
            // outcome and should be counted as processed, not skipped.
            if (!$anyCellAnswered) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' has no subjects marked — nothing registered.";
                continue;
            }

            $this->studentsProcessed++;
            $this->imported[$studentId] = $registeredNames;
        }
    }

    private function importUace(Collection $rows): void
    {
        $combinationCol = $this->resolveCombinationColumn($rows->first());

        if ($combinationCol === null) {
            $this->skippedRows[] = 'Could not find the "Combination" column in the header row — check that it was not renamed.';
            return;
        }

        foreach ($rows->skip(1) as $index => $row) {
            $excelRow = $index + 2;

            $studentId = trim((string) ($row[1] ?? ''));

            if ($studentId === '') {
                continue; // blank row, ignore silently
            }

            if (!$this->belongsHere($studentId)) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' is not a {$this->category} student of school {$this->schoolNumber} for {$this->year} — skipped.";
                continue;
            }

            $code = trim((string) ($row[$combinationCol] ?? ''));

            if ($code === '') {
                // Left blank — nothing to assign yet, not an error; the
                // school may fill this in a later import.
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' has no combination selected — nothing registered.";
                continue;
            }

            $combination = $this->combinations->findByCode('UACE', $code);

            if (!$combination) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' — '{$code}' is not a recognised, active combination code — skipped.";
                continue;
            }

            $this->combinations->setStudentCombination(
                $studentId,
                $combination->id,
                $this->category,
                $this->year,
                $this->schoolNumber
            );

            $this->studentsProcessed++;
            $this->imported[$studentId] = $combination->code;
        }
    }

    private function belongsHere(string $studentId): bool
    {
        return ClassAllocation::where('Student_ID', $studentId)
            ->where('Student_ID', 'LIKE', "{$this->schoolNumber}-%")
            ->where('Student_ID', 'LIKE', "%-{$this->category}-%")
            ->where('Student_ID', 'LIKE', "%-{$this->year}")
            ->exists();
    }

    public function getSummary(): array
    {
        return [
            'students_processed' => $this->studentsProcessed,
            'imported' => $this->imported,
            'skipped' => $this->skippedRows,
        ];
    }
}