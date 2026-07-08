<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExamSummary extends Model
{
    protected $fillable = [
        'student_id',
        'exam_id',
        'class_id',
        'stream_id',
        'subjects_count',
        'total_marks',
        'average',
        'rank',
        'school_id',
        'grade',
    ];
}

