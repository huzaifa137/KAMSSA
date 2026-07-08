<?php
namespace App\Exports;

use App\Models\Student;
use App\Models\ClassStreamAssignment;
use App\Models\ClassSubject;
use App\Http\Controllers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClassStudentsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $classId;
    protected $subjects = [];

    public function __construct($classId)
    {
        $this->classId = $classId;
        $this->loadSubjects();
    }


    protected function loadSubjects()
    {
        $ClassStreams = ClassStreamAssignment::where('class_id', $this->classId)
            ->where('school_id', session('LoggedSchool'))
            ->pluck('stream_id');

        $this->subjects = ClassSubject::where('class_id', $this->classId)
            ->where('school_id', session('LoggedSchool'))
            ->whereIn('stream_id', $ClassStreams)
            ->select('subject_id')
            ->distinct()
            ->pluck('subject_id')
            ->map(function ($id) {
                return Helper::item_md_name($id);
            })
            ->toArray();
    }

    public function collection()
    {
        return Student::where('school_id', session('LoggedSchool'))
            ->where('senior', $this->classId)
            ->orderBy('stream')
            ->orderBy('firstname')
            ->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Student ID',
            'Full Name',
            'Class',
            'Stream',
        ];

        foreach ($this->subjects as $subject) {
            $headers[] = $subject;
        }

        return $headers;
    }

    public function map($student): array
    {
        static $no = 1;

        $row = [
            $no++,
            $student->id,
            $student->firstname . ' ' . $student->lastname,
            Helper::item_md_name($this->classId),
            Helper::item_md_name($student->stream),
        ];

        foreach ($this->subjects as $subject) {
            $row[] = '';
        }

        return $row;
    }

    public function title(): string
    {
        return Helper::item_md_name($this->classId);
    }
}
