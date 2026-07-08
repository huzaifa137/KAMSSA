<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class StudentsExamExport implements FromArray
{
    protected $students;
    protected $subjects;
    protected $year;

    public function __construct($students, $subjects, $year)
    {
        $this->students = $students;
        $this->subjects = $subjects;
        $this->year = $year;
    }

    public function array(): array
    {
        $data = [];

        // Header row
        $header = ['No', 'Admission Number', 'Name', 'Active Year'];

        foreach ($this->subjects as $subject) {
            $header[] = $subject->md_name;
        }

        $data[] = $header;

        // Student rows
        foreach ($this->students as $index => $student) {

            $row = [
                $index + 1,
                $student->admission_number,
                $student->firstname . ' ' . $student->lastname,
                $this->year
            ];

            // Add empty columns for subjects (for marks entry later)
            foreach ($this->subjects as $subject) {
                $row[] = '';
            }

            $data[] = $row;
        }

        return $data;
    }
}
