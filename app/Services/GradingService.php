<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\StudentExamResult;
use Illuminate\Support\Collection;

class GradingService
{
    /*
    |--------------------------------------------------------------------------
    | MAIN ENTRY – National / School Exam Results
    |--------------------------------------------------------------------------
    */

    public function calculateExamResults($examId, $filters = [])
    {
        $exam = Exam::with('school')->findOrFail($examId);

        $results = StudentExamResult::with([
                'student.school',
                'subject',
                'exam'
            ])
            ->where('exam_id', $examId)
            ->get()
            ->groupBy('student_id');

        $students = $results->map(function ($subjects, $studentId) {

            $student = $subjects->first()->student;

            $total = $subjects->sum('marks');
            $average = $subjects->avg('marks');

            return (object)[
                'student_id' => $studentId,
                'student_name' => $student->firstname . ' ' . $student->lastname,
                'admission_number' => $student->admission_number,
                'gender' => $student->gender,
                'stream' => $student->stream,
                'school_name' => $student->school->name ?? 'N/A',
                'total_marks' => $total,
                'average_marks' => $average,
                'grade' => $this->calculateGrade($average),
            ];
        });

        // Apply optional filters (for dashboard)
        if (!empty($filters['school_id'])) {
            $students = $students->where('school_id', $filters['school_id']);
        }

        // Rank students
        return $this->rankStudents($students);
    }

    /*
    |--------------------------------------------------------------------------
    | Rank Logic (Handles Ties)
    |--------------------------------------------------------------------------
    */

    public function rankStudents(Collection $students)
    {
        $students = $students->sortByDesc('total_marks')->values();

        $rank = 1;

$students = $students
    ->sortByDesc('total_marks')
    ->values()
    ->map(function ($student, $index) {
        $student->rank = $index + 1;
        return $student;
    });


        return $students;
    }

    /*
    |--------------------------------------------------------------------------
    | Subject Grades Per Student (Report Card)
    |--------------------------------------------------------------------------
    */

    public function getStudentReport($examId, $studentId)
    {
        $subjects = StudentExamResult::with(['subject', 'student.school'])
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->get();

        if ($subjects->isEmpty()) {
            return null;
        }

        $total = $subjects->sum('marks');
        $average = $subjects->avg('marks');

        return [
            'student' => $subjects->first()->student,
            'subjects' => $subjects->map(function ($row) {
                return [
                    'subject_name' => $row->subject->md_name,
                    'marks' => $row->marks,
                    'grade' => $this->calculateGrade($row->marks)
                ];
            }),
            'total_marks' => $total,
            'average_marks' => $average,
            'grade' => $this->calculateGrade($average)
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Subject Statistics (Best / Hardest)
    |--------------------------------------------------------------------------
    */

    public function subjectStatistics($examType, $academicYear)
    {
        $results = StudentExamResult::with(['subject', 'exam'])
            ->whereHas('exam', function ($q) use ($examType, $academicYear) {
                $q->where('exam_type', $examType)
                  ->where('academic_year', $academicYear);
            })
            ->get()
            ->groupBy('subject_id');

        $stats = $results->map(function ($rows) {
            return [
                'subject_name' => $rows->first()->subject->md_name,
                'average_marks' => $rows->avg('marks'),
                'highest_mark' => $rows->max('marks'),
                'lowest_mark' => $rows->min('marks'),
            ];
        });

        return [
            'best_subject' => $stats->sortByDesc('average_marks')->first(),
            'hardest_subject' => $stats->sortBy('average_marks')->first(),
            'all_subjects' => $stats->sortByDesc('average_marks')->values()
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Pass Rate
    |--------------------------------------------------------------------------
    */

    public function passRate($examId, $passMark = 50)
    {
        $students = $this->calculateExamResults($examId);

        $totalStudents = $students->count();

        if ($totalStudents === 0) {
            return 0;
        }

        $passed = $students->filter(function ($student) use ($passMark) {
            return $student['average_marks'] >= $passMark;
        })->count();

        return round(($passed / $totalStudents) * 100, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | Grade Calculation
    |--------------------------------------------------------------------------
    */

    public function calculateGrade($percentage)
    {
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
}
