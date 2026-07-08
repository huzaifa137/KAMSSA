<?php

namespace App\Imports;

use App\Http\Controllers\Helper;
use App\Models\ClassAllocation;
use App\Models\StudentBasic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

/**
 * Reads the sheet produced by StudentBulkImportTemplateExport and creates
 * one students_basic + class_allocation row per valid row, auto-generating
 * Student_ID in the same schoolNumber-category-number-year format used
 * everywhere else in the system (see StudentController::generateStudentID).
 *
 * Column layout (fixed, matches the export):
 *   0: No
 *   1: Student Name            (required)
 *   2: Student Name (AR)
 *   3: Sex (Male/Female)       (required)
 *   4: Date of Birth (YYYY-MM-DD)
 *   5: Nationality
 *   6: District
 *   7: Guardian Name
 *   8: Guardian Contact
 *
 * Bad rows are skipped individually (not rolled back as a whole) so one
 * typo doesn't block the rest of the class from being imported.
 */
class StudentBulkImportImport implements ToCollection
{
    protected string $category;
    protected string $year;
    protected string $schoolId;      // houses.ID — needed for the House name field
    protected string $schoolNumber;  // houses.Number — used inside the Student_ID

    protected int $nextNumber;

    protected array $created = [];    // ['student_id' => ..., 'name' => ...]
    protected array $skippedRows = [];
    protected int $studentsProcessed = 0;

    /** category => [Class, Class_AR] shown on the student's record */
    private const CLASS_MAP = [
        'PLE' => ['Primary Seven', null],
        'ID' => ['Senior Four', 'الإعدادية'],
        'TH' => ['Senior Six', 'الثانوي'],
        'UCE' => ['Senior Four', null],
        'UACE' => ['Senior Six', null],
    ];

    public function __construct(string $category, string $year, string $schoolId, string $schoolNumber)
    {
        $this->category = $category;
        $this->year = $year;
        $this->schoolId = $schoolId;
        $this->schoolNumber = $schoolNumber;

        $lastNumber = DB::table('students_basic')
            ->where('Student_ID', 'LIKE', $schoolNumber . '-' . $category . '-%-' . $year)
            ->selectRaw("
                MAX(
                    CAST(
                        SUBSTRING_INDEX(SUBSTRING_INDEX(Student_ID, '-', 4), '-', -1)
                        AS UNSIGNED
                    )
                ) as max_number
            ")
            ->value('max_number');

        $this->nextNumber = ($lastNumber ?? 0) + 1;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            $this->skippedRows[] = 'The uploaded file has no data rows.';
            return;
        }

        [$class, $classAr] = self::CLASS_MAP[$this->category] ?? ['Senior Six', null];
        $houseName = Helper::schoolNameByID($this->schoolId);

        // First row is the heading row produced by the export — skip it.
        foreach ($rows->skip(1) as $index => $row) {
            $excelRow = $index + 2; // account for header + 0-based skip

            $name = trim((string) ($row[1] ?? ''));
            $nameAr = trim((string) ($row[2] ?? ''));
            $sexRaw = trim((string) ($row[3] ?? ''));
            $dob = trim((string) ($row[4] ?? ''));
            $nationality = trim((string) ($row[5] ?? ''));
            $district = trim((string) ($row[6] ?? ''));
            $guardianName = trim((string) ($row[7] ?? ''));
            $guardianContact = trim((string) ($row[8] ?? ''));

            if ($name === '' && $sexRaw === '') {
                continue; // fully blank row, ignore silently
            }

            if ($name === '') {
                $this->skippedRows[] = "Row {$excelRow}: Student Name is required — skipped.";
                continue;
            }

            $sex = $this->normalizeSex($sexRaw);
            if ($sex === null) {
                $this->skippedRows[] = "Row {$excelRow}: '{$name}' — Sex must be Male or Female — skipped.";
                continue;
            }

            $dateOfBirth = null;
            if ($dob !== '') {
                try {
                    $dateOfBirth = \Carbon\Carbon::parse($dob)->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->skippedRows[] = "Row {$excelRow}: '{$name}' — Date of Birth '{$dob}' is not a valid date — skipped.";
                    continue;
                }
            }

            $studentId = $this->schoolNumber . '-' . $this->category . '-'
                . str_pad($this->nextNumber, 3, '0', STR_PAD_LEFT) . '-' . $this->year;

            try {
                DB::transaction(function () use (
                    $studentId, $name, $nameAr, $sex, $dateOfBirth, $nationality,
                    $district, $guardianName, $guardianContact, $houseName, $class, $classAr
                ) {
                    $student = StudentBasic::create([
                        'Student_ID' => $studentId,
                        'Student_Name' => $name,
                        'Student_Name_AR' => $nameAr ?: null,
                        'Date_of_Birth' => $dateOfBirth,
                        'Date_of_Birth_AR' => Helper::toArabicDate($dateOfBirth),
                        'StudentSex' => $sex,
                        'StudentsNationality' => $nationality ?: null,
                        'StudentsCitizenship' => $nationality
                            ? Helper::toArabicLettersCountriesAndWordsPackage($nationality)
                            : null,
                        'District' => $district ?: null,
                        'GuardianName' => $guardianName ?: null,
                        'GuardiansContact' => $guardianContact ?: null,
                        'House' => $houseName,
                        'admnyr' => $this->year,
                        'EntryDate' => now(),
                        'Section' => 'Day',
                        'Class' => $class,
                        'Class_AR' => $classAr,
                        'state' => 'Active',
                    ]);

                    ClassAllocation::create([
                        'Student_ID' => $student->Student_ID,
                        'Class_ID' => 001,
                    ]);
                });
            } catch (\Exception $e) {
                $this->skippedRows[] = "Row {$excelRow}: '{$name}' — could not be saved ({$e->getMessage()}) — skipped.";
                continue;
            }

            $this->created[] = ['student_id' => $studentId, 'name' => $name];
            $this->studentsProcessed++;
            $this->nextNumber++;
        }
    }

    private function normalizeSex(string $raw): ?string
    {
        $value = strtoupper(trim($raw));

        if (in_array($value, ['MALE', 'M'], true)) {
            return 'Male';
        }

        if (in_array($value, ['FEMALE', 'F'], true)) {
            return 'Female';
        }

        return null;
    }

    public function getSummary(): array
    {
        return [
            'students_processed' => $this->studentsProcessed,
            'created' => $this->created,
            'skipped' => $this->skippedRows,
        ];
    }
}