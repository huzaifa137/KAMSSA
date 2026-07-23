<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Downloadable Excel template for bulk-importing students into a given
 * year/category/school, before Student_ID / Subject Registration exist for
 * them. Student_ID is intentionally NOT a column here — it is generated
 * automatically on import (schoolNumber-category-number-year), so schools
 * only ever fill in Student Name and Sex.
 */
class StudentBulkImportTemplateExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    protected string $category;
    protected string $year;
    protected string $schoolNumber;

    public function __construct(string $category, string $year, string $schoolNumber)
    {
        $this->category = $category;
        $this->year = $year;
        $this->schoolNumber = $schoolNumber;
    }

    public function array(): array
    {
        // A couple of example rows so schools can see the expected format.
        // These are safe to delete before uploading.
        return [
            [1, 'NAKATO JANE', 'Female'],
            [2, 'OKELLO JOHN', 'Male'],
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Student Name *',
            'Sex * (Male/Female)',
        ];
    }

    public function title(): string
    {
        return "{$this->category}-{$this->year}-{$this->schoolNumber}";
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('9D1A68');
        $sheet->getStyle('A1:C1')->getFont()->getColor()->setRGB('FFFFFF');

        return [];
    }
}