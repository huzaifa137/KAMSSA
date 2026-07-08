<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExamStatisticsExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [
            new OverviewSheet($this->data),
            new TopStudentsSheet($this->data),
            new SubjectPerformanceSheet($this->data),
        ];

        return $sheets;
    }
}

// Overview Sheet
class OverviewSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Overview';
    }

    public function collection()
    {
        $collection = collect([]);

        // Title
        $collection->push(['EXAM STATISTICS REPORT']);
        $collection->push(["{$this->data['year']} - {$this->data['category']} - {$this->data['levelName']}"]);
        $collection->push(['']);

        // 1. Schools Registered
        $collection->push(['1. NUMBER OF SCHOOLS REGISTERED']);
        $collection->push(['S/N', $this->data['levelName']]);
        $collection->push(['1', $this->data['schoolsCount']]);
        $collection->push(['']);

        // 2. Students Registered
        $collection->push(['2. NUMBER OF STUDENTS REGISTERED']);
        $collection->push(['S/N', $this->data['levelName'], 'Total']);
        $collection->push(['1', $this->data['registeredStudents'], $this->data['registeredStudents']]);
        $collection->push(['']);

        // 3. Grading Summary
        $collection->push(['3. GRADING SUMMARY']);
        $collection->push(['S/N', 'Grade', 'Male', 'Male %', 'Female', 'Female %', 'Total']);

        $grades = ['D1', 'D2', 'C3', 'C4'];
        $labels = ['Excellent D1', 'Very good D2', 'Good C3', 'Pass C4'];
        $serial = ['a', 'b', 'c', 'd'];

        foreach ($grades as $index => $grade) {
            if (isset($this->data['gradingSummary'][$grade])) {
                $g = $this->data['gradingSummary'][$grade];
                $collection->push([
                    $serial[$index] . '.',
                    $labels[$index],
                    $g['male_count'],
                    $g['male_percent'] . '%',
                    $g['female_count'],
                    $g['female_percent'] . '%',
                    $g['total']
                ]);
            }
        }

        // Totals
        $collection->push([
            '',
            'Total',
            $this->data['totals']['male_total'],
            $this->data['totals']['male_total'] > 0 ? 
                round(($this->data['totals']['male_total'] / $this->data['totals']['overall_total']) * 100, 2) . '%' : '0%',
            $this->data['totals']['female_total'],
            $this->data['totals']['female_total'] > 0 ? 
                round(($this->data['totals']['female_total'] / $this->data['totals']['overall_total']) * 100, 2) . '%' : '0%',
            $this->data['totals']['overall_total']
        ]);
        $collection->push(['']);

        // 4. Failed Students
        $collection->push(['4. STUDENTS FAILED']);
        $collection->push(['S/N', $this->data['levelName'], 'Male', 'Female', 'Total']);
        $collection->push([
            '1', 
            '', 
            $this->data['failedBreakdown']['male_failed'], 
            $this->data['failedBreakdown']['female_failed'], 
            $this->data['failedBreakdown']['total_failed']
        ]);

        return $collection;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A9:G9')->getFont()->setBold(true);
        $sheet->getStyle('A15:G15')->getFont()->setBold(true);
        $sheet->getStyle('A23:G23')->getFont()->setBold(true);
        
        // Add borders to tables
        $sheet->getStyle('A5:C7')->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('A10:G14')->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('A18:G20')->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        return [];
    }
}

// Top Students Sheet
class TopStudentsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Top Students';
    }

    public function collection()
    {
        $collection = collect([]);
        
        $collection->push(['TOP 10 PERFORMING STUDENTS']);
        $collection->push([$this->data['levelName']]);
        $collection->push(['']);

        foreach ($this->data['topStudents'] as $index => $student) {
            $rank = $index + 1;
            $rankText = $rank . ($rank == 1 ? 'st' : ($rank == 2 ? 'nd' : ($rank == 3 ? 'rd' : 'th')));
            
            $collection->push([
                $rankText,
                $student['student_id'],
                $student['student_name'],
                $student['school_name'],
                ucfirst($student['gender']),
                number_format($student['total_marks'], 2),
                number_format($student['percentage'], 2) . '%',
                $student['grade']
            ]);
        }

        $collection->push(['']);
        $collection->push(['SUMMARY STATISTICS']);
        $collection->push([
            'Average: ' . number_format(collect($this->data['topStudents'])->avg('percentage'), 2) . '%',
            'Male: ' . collect($this->data['topStudents'])->where('gender', 'male')->count(),
            'Female: ' . collect($this->data['topStudents'])->where('gender', 'female')->count(),
            'Top Score: ' . (isset($this->data['topStudents'][0]) ? 
                number_format($this->data['topStudents'][0]['percentage'], 2) . '%' : '0%')
        ]);

        return $collection;
    }

    public function headings(): array
    {
        return ['Rank', 'Student ID', 'Name', 'School', 'Gender', 'Total Marks', 'Percentage', 'Grade'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);
        $sheet->getStyle('A4:H' . (4 + count($this->data['topStudents'])))->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        return [];
    }
}

// Subject Performance Sheet
class SubjectPerformanceSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Subject Performance';
    }

    public function collection()
    {
        $collection = collect([]);

        // Best Subjects
        $collection->push(['TOP 10 BEST PERFORMING SUBJECTS']);
        $collection->push(['']);

        foreach ($this->data['bestSubjects'] as $index => $subject) {
            $collection->push([
                $index + 1,
                $subject['subject_name'],
                $subject['student_count'],
                number_format($subject['average'], 2) . '%',
                $subject['highest'] . '%',
                $subject['pass_percentage'] . '%'
            ]);
        }

        $collection->push(['']);
        $collection->push(['TOP 10 WORST PERFORMING SUBJECTS']);
        $collection->push(['']);

        foreach ($this->data['worstSubjects'] as $index => $subject) {
            $collection->push([
                $index + 1,
                $subject['subject_name'],
                $subject['student_count'],
                number_format($subject['average'], 2) . '%',
                $subject['lowest'] . '%',
                $subject['pass_percentage'] . '%'
            ]);
        }

        return $collection;
    }

    public function headings(): array
    {
        return ['Rank', 'Subject Name', 'Students', 'Average %', 'Highest/Lowest %', 'Pass Rate %'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A8')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2:F2')->getFont()->setBold(true);
        $sheet->getStyle('A9:F9')->getFont()->setBold(true);
        
        // Add borders
        $lastBestRow = 2 + count($this->data['bestSubjects']);
        $sheet->getStyle('A2:F' . $lastBestRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        $lastWorstRow = 9 + count($this->data['worstSubjects']);
        $sheet->getStyle('A9:F' . $lastWorstRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        return [];
    }
}