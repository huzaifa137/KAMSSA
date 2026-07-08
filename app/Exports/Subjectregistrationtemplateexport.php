<?php

namespace App\Exports;

use App\Models\ClassAllocation;
use App\Models\MasterData;
use App\Models\StudentBasic;
use App\Models\StudentSubjectRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Downloadable Excel template for registering which optional subjects each
 * UCE/UACE student sat, ahead of marks entry. Compulsory subjects are
 * pre-marked YES and locked in place by convention (still editable, but the
 * importer always registers them regardless of what the cell says).
 */
class SubjectRegistrationTemplateExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected string $category;
    protected string $year;
    protected string $schoolNumber;
    protected Collection $subjects; // MasterData rows, compulsory first

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
            ->get();
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

        foreach ($this->subjects as $subject) {
            $tag = $subject->md_misc1 === 'Compulsory' ? 'Compulsory' : 'Optional';
            $headers[] = $subject->md_name . " [{$tag}]";
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

        foreach ($this->subjects as $subject) {
            if ($subject->md_misc1 === 'Compulsory') {
                $line[] = 'YES';
            } else {
                $line[] = $row->registered->has($subject->md_id) ? 'YES' : '';
            }
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
}