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
 * only ever fill in human details.
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
            [1, 'NAKATO JANE', '', 'Female', '2008-04-12', 'Ugandan', 'Kampala', 'MUKASA PETER', '0700000000'],
            [2, 'OKELLO JOHN', '', 'Male', '2007-11-03', 'Ugandan', 'Gulu', 'ACEN MARY', '0700000001'],
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Student Name *',
            'Student Name (AR)',
            'Sex * (Male/Female)',
            'Date of Birth (YYYY-MM-DD)',
            'Nationality',
            'District',
            'Guardian Name',
            'Guardian Contact',
        ];
    }

    public function title(): string
    {
        return "{$this->category}-{$this->year}-{$this->schoolNumber}";
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('9D1A68');
        $sheet->getStyle('A1:I1')->getFont()->getColor()->setRGB('FFFFFF');

        return [];
    }
}