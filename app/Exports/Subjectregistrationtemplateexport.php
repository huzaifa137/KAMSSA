<?php

namespace App\Exports;

use App\Models\ClassAllocation;
use App\Models\Combination;
use App\Models\MasterData;
use App\Models\StudentBasic;
use App\Models\StudentCombination;
use App\Models\StudentSubjectRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Downloadable Excel template for registering which optional subjects each
 * UCE/UACE student sat, ahead of marks entry.
 *
 * Compulsory subjects are intentionally left out of this sheet: they are
 * auto-registered for every student on the management screen regardless of
 * what any spreadsheet says, so there is nothing useful to edit for them
 * here.
 *
 * UCE: one column per optional subject, each restricted to a YES/NO
 * dropdown, so a school flips a student on/off a subject in one click.
 *
 * UACE: a UACE student doesn't freely mix optional subjects — they sit one
 * standardized Combination (e.g. PCM), which determines their principal
 * subjects. So instead of one YES/NO column per subject, UACE gets a
 * single "Combination" column restricted to a dropdown of Active
 * combination codes — a school can't type an invalid one.
 */
class SubjectRegistrationTemplateExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithEvents
{
    protected string $category;
    protected string $year;
    protected string $schoolNumber;
    protected Collection $subjects; // UCE only: Optional MasterData rows
    protected Collection $combinations; // UACE only: Active combinations for this category

    public function __construct(string $category, string $year, string $schoolNumber)
    {
        $this->category = $category;
        $this->year = $year;
        $this->schoolNumber = $schoolNumber;

        if ($category === 'UACE') {
            $this->combinations = Combination::where('category', 'UACE')
                ->where('status', 'Active')
                ->orderBy('code')
                ->get();
            $this->subjects = collect();
            return;
        }

        $masterCode = config('constants.options.UCEPapers');

        $this->subjects = MasterData::where('md_master_code_id', $masterCode)
            ->where(function ($q) {
                $q->whereNull('md_misc2')->orWhere('md_misc2', '!=', 'Inactive');
            })
            ->where(function ($q) {
                $q->whereNull('md_misc1')->orWhere('md_misc1', '!=', 'Compulsory');
            })
            ->orderBy('md_name')
            ->get();
        $this->combinations = collect();
    }

    public function collection()
    {
        $students = ClassAllocation::where('Student_ID', 'LIKE', "{$this->schoolNumber}-%")
            ->where('Student_ID', 'LIKE', "%-{$this->category}-%")
            ->where('Student_ID', 'LIKE', "%-{$this->year}")
            ->select('Student_ID')
            ->distinct()
            ->orderBy('Student_ID')
            ->get();

        $names = StudentBasic::whereIn('Student_ID', $students->pluck('Student_ID'))
            ->pluck('Student_Name', 'Student_ID');

        if ($this->category === 'UACE') {
            $currentCombinationCodes = StudentCombination::with('combination')
                ->whereIn('student_id', $students->pluck('Student_ID'))
                ->where('year', $this->year)
                ->get()
                ->mapWithKeys(fn($sc) => [$sc->student_id => $sc->combination?->code]);

            return $students->map(function ($row) use ($names, $currentCombinationCodes) {
                return (object) [
                    'student_id' => $row->Student_ID,
                    'student_name' => $names[$row->Student_ID] ?? '',
                    'combination_code' => $currentCombinationCodes[$row->Student_ID] ?? '',
                ];
            });
        }

        $existing = StudentSubjectRegistration::whereIn('student_id', $students->pluck('Student_ID'))
            ->where('year', $this->year)
            ->get()
            ->groupBy('student_id');

        return $students->map(function ($row) use ($names, $existing) {
            return (object) [
                'student_id' => $row->Student_ID,
                'student_name' => $names[$row->Student_ID] ?? '',
                'registered' => $existing->get($row->Student_ID, collect())->pluck('subject_id')->flip(),
            ];
        });
    }

    public function headings(): array
    {
        $headers = ['No', 'Student_ID (do not edit)', 'Student Name'];

        if ($this->category === 'UACE') {
            $headers[] = 'Combination';
            return $headers;
        }

        foreach ($this->subjects as $subject) {
            $headers[] = $subject->md_name . ' [Optional]';
        }

        return $headers;
    }

    public function map($row): array
    {
        static $no = 1;

        $line = [
            $no++,
            $row->student_id,
            $row->student_name,
        ];

        if ($this->category === 'UACE') {
            $line[] = $row->combination_code;
            return $line;
        }

        foreach ($this->subjects as $subject) {
            $line[] = $row->registered->has($subject->md_id) ? 'YES' : 'NO';
        }

        return $line;
    }

    public function title(): string
    {
        return "{$this->category}-{$this->year}-{$this->schoolNumber}";
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Z1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('9D1A68');
        $sheet->getStyle('A1:Z1')->getFont()->getColor()->setRGB('FFFFFF');

        return [];
    }

    /**
     * UCE: restrict every optional-subject cell to a YES/NO dropdown.
     * UACE: restrict the single Combination column to a dropdown of
     * Active combination codes, so a school can't type an invalid one.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                if ($highestRow < 2) {
                    return;
                }

                if ($this->category === 'UACE') {
                    if ($this->combinations->isEmpty()) {
                        return;
                    }

                    $colLetter = 'D'; // A=No, B=Student_ID, C=Student Name, D=Combination
                    $codeList = $this->combinations->pluck('code')->implode(',');

                    for ($row = 2; $row <= $highestRow; $row++) {
                        $validation = $sheet->getCell("{$colLetter}{$row}")->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setErrorStyle(DataValidation::STYLE_STOP);
                        $validation->setAllowBlank(true);
                        $validation->setShowInputMessage(true);
                        $validation->setShowErrorMessage(true);
                        $validation->setShowDropDown(true);
                        $validation->setErrorTitle('Invalid combination');
                        $validation->setError('Please choose a combination code from the dropdown.');
                        $validation->setPromptTitle("Student's Combination");
                        $validation->setPrompt('Choose one combination code.');
                        $validation->setFormula1('"' . $codeList . '"');
                    }

                    return;
                }

                if ($this->subjects->isEmpty()) {
                    return;
                }

                $firstSubjectColIndex = 4; // A=No, B=Student_ID, C=Student Name, D...=subjects
                $lastSubjectColIndex = 3 + $this->subjects->count();

                for ($col = $firstSubjectColIndex; $col <= $lastSubjectColIndex; $col++) {
                    $colLetter = Coordinate::stringFromColumnIndex($col);

                    for ($row = 2; $row <= $highestRow; $row++) {
                        $validation = $sheet->getCell("{$colLetter}{$row}")->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setErrorStyle(DataValidation::STYLE_STOP);
                        $validation->setAllowBlank(false);
                        $validation->setShowInputMessage(true);
                        $validation->setShowErrorMessage(true);
                        $validation->setShowDropDown(true);
                        $validation->setErrorTitle('Invalid entry');
                        $validation->setError('Please choose YES or NO from the dropdown.');
                        $validation->setPromptTitle('Registered for this subject?');
                        $validation->setPrompt('Choose YES or NO.');
                        $validation->setFormula1('"YES,NO"');
                    }
                }
            },
        ];
    }
}