<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\Models\StudentResult;
use App\Http\Controllers\Helper;

class ClassResultsImport implements ToCollection, WithHeadingRow
{
    protected $classId;
    protected $examId;

    public function __construct($classId, $examId)
    {
        $this->classId = $classId;
        $this->examId = $examId;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $studentId = $row['student_id'];

            if (!$studentId) {
                continue;
            }

            foreach ($row as $column => $value) {

                // Skip non-subject columns
                if (
                    in_array($column, [
                        'no',
                        'student_id',
                        'full_name',
                        'class',
                        'stream'
                    ])
                ) {
                    continue;
                }

                if ($value === null || $value === '') {
                    continue;
                }

                // Convert subject name back to subject_id
                $subjectId = Helper::item_md_id($column);

                if (!$subjectId) {
                    continue;
                }

                StudentResult::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'exam_id' => $this->examId,
                        'class_id' => $this->classId,
                        'school_id' => session('LoggedSchool'),
                    ],
                    [
                        'marks' => $value,
                        'stream_id' => Helper::studentStream($studentId),
                        'uploaded_by' => session('LoggedStudent'),
                    ]
                );
            }
        }
    }
}

