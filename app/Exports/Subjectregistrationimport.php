<?php

namespace App\Imports;

use App\Models\ClassAllocation;
use App\Models\MasterData;
use App\Models\StudentSubjectRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

/**
 * Reads the sheet produced by SubjectRegistrationTemplateExport and upserts
 * student_subject_registrations rows accordingly.
 *
 * Column layout (fixed, matches the export):
 *   0: No
 *   1: Student_ID
 *   2: Student Name
 *   3...: one column per subject, in the same order the template was built.
 *
 * Compulsory subjects are always registered, regardless of what the cell
 * says. Optional subjects are registered only when the cell contains a
 * recognisable "yes" marker (YES, Y, 1, X, TRUE).
 */
class SubjectRegistrationImport implements ToCollection
{
    protected string $category;
    protected string $year;
    protected string $schoolNumber;
    protected Collection $subjects; // ordered MasterData rows, same order as the template

    protected array $imported = [];   // student_id => [subject names registered]
    protected array $skippedRows = []; // human-readable row errors
    protected int $studentsProcessed = 0;

    private const YES_MARKERS = ['YES', 'Y', '1', 'X', 'TRUE'];

    public function __construct(string $category, string $year, string $schoolNumber)
    {
        $this->category = $category;
        $this->year = $year;
        $this->schoolNumber = $schoolNumber;

        $masterCode = $category === 'UACE'
            ? config('constants.options.UACEPapers')
            : config('constants.options.UCEPapers');

        $this->subjects = MasterData::where('md_master_code_id', $masterCode)
            ->where(function ($q) {
                $q->whereNull('md_misc2')->orWhere('md_misc2', '!=', 'Inactive');
            })
            ->orderByRaw("md_misc1 = 'Compulsory' desc")
            ->orderBy('md_name')
            ->get()
            ->values();
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            $this->skippedRows[] = 'The uploaded file has no data rows.';
            return;
        }

        // First row is the heading row produced by the export — skip it.
        foreach ($rows->skip(1) as $index => $row) {
            $excelRow = $index + 2; // account for header + 0-based skip

            $studentId = trim((string) ($row[1] ?? ''));

            if ($studentId === '') {
                continue; // blank row, ignore silently
            }

            $belongsHere = ClassAllocation::where('Student_ID', $studentId)
                ->where('Student_ID', 'LIKE', "{$this->schoolNumber}-%")
                ->where('Student_ID', 'LIKE', "%-{$this->category}-%")
                ->where('Student_ID', 'LIKE', "%-{$this->year}")
                ->exists();

            if (!$belongsHere) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' is not a {$this->category} student of school {$this->schoolNumber} for {$this->year} — skipped.";
                continue;
            }

            $registeredNames = [];

            foreach ($this->subjects->values() as $i => $subject) {
                $colIndex = 3 + $i;
                $cell = strtoupper(trim((string) ($row[$colIndex] ?? '')));
                $isCompulsory = $subject->md_misc1 === 'Compulsory';
                $isMarked = in_array($cell, self::YES_MARKERS, true);

                if ($isCompulsory || $isMarked) {
                    StudentSubjectRegistration::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'subject_id' => $subject->md_id,
                            'year' => $this->year,
                        ],
                        [
                            'category' => $this->category,
                            'is_compulsory' => $isCompulsory,
                            'school_number' => $this->schoolNumber,
                        ]
                    );
                    $registeredNames[] = $subject->md_name;
                } else {
                    // Cell left blank / marked no — make sure any previous
                    // registration for this optional subject is removed.
                    StudentSubjectRegistration::where('student_id', $studentId)
                        ->where('subject_id', $subject->md_id)
                        ->where('year', $this->year)
                        ->delete();
                }
            }

            if (empty($registeredNames)) {
                $this->skippedRows[] = "Row {$excelRow}: '{$studentId}' has no subjects marked — nothing registered.";
                continue;
            }

            $this->studentsProcessed++;
            $this->imported[$studentId] = $registeredNames;
        }
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