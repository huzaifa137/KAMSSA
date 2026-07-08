<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'subject_id',
        'marks',
    ];

    // // StudentExamResult.php
    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(\App\Models\MasterData::class, 'subject_id', 'md_id');
    // }

}
