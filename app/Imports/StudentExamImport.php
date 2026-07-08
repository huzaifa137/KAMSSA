<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\Student;
use App\Models\StudentExamResult;
use Illuminate\Validation\ValidationException;

class StudentExamImport implements ToCollection
{
    protected $exam;
    protected $subjects;
    protected $errors = [];

    public function __construct($exam, $subjects)
    {
        $this->exam = $exam;
        $this->subjects = $subjects;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception("Uploaded file is empty.");
        }

        $header = $rows->first();

        $expectedSubjects = $this->subjects->pluck('md_name')->values();
        $excelSubjects = collect($header)->slice(4)->values();

        if ($excelSubjects->count() !== $expectedSubjects->count()) {
            throw new \Exception("Uploaded file does not match expected number of subjects for this exam type.");
        }

        foreach ($expectedSubjects as $index => $subjectName) {
            if (trim($excelSubjects[$index]) !== trim($subjectName)) {
                throw new \Exception("Uploaded file subjects do not match {$this->exam->exam_type} subjects.");
            }
        }

        foreach ($rows->skip(1) as $rowIndex => $row) {

            $excelRowNumber = $rowIndex + 2; // +2 because we skipped header and index starts at 0

            $admissionNumber = $row[1] ?? null;

            if (!$admissionNumber) {
                $this->errors[] = "Row {$excelRowNumber}: Admission number is missing.";
                throw new \Exception("Admission number is missing.");
            }

            $student = Student::where('admission_number', $admissionNumber)
                ->where('school_id', $this->exam->school_id)
                ->first();

            if (!$student) {
                $this->errors[] = "Row {$excelRowNumber}: Student with admission number '{$admissionNumber}' not found in this school.";
                throw new \Exception("Row {$excelRowNumber}: Student with admission number '{$admissionNumber}' not found in this school. <br> please make sure your uploading excel sheet for '{$admissionNumber}'");
            }

            foreach ($this->subjects as $index => $subject) {

                $marks = $row[$index + 4] ?? null;

                if ($marks === null || $marks === '') {
                    $this->errors[] = "Row {$excelRowNumber}: Missing marks for subject {$subject->md_name}.";
                    continue;
                }

                if (!is_numeric($marks)) {
                    $this->errors[] = "Row {$excelRowNumber}: Invalid marks value '{$marks}' for subject {$subject->md_name}.";
                    continue;
                }

                StudentExamResult::create([
                    'exam_id' => $this->exam->id,
                    'student_id' => $student->id,
                    'subject_id' => $subject->md_id,
                    'marks' => $marks
                ]);
            }
        }

        // After processing all rows → if errors exist, throw validation exception
        if (!empty($this->errors)) {
            throw ValidationException::withMessages([
                'import_errors' => $this->errors
            ]);
        }
    }
}
