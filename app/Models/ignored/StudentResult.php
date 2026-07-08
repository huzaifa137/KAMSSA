<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;

    protected $table = 'student_results';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'stream_id',
        'subject_id',
        'exam_id',
        'marks',
        'school_id',
        'added_by',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'marks' => 'decimal:2',
    ];

    /* ==========================
       RELATIONSHIPS
       ========================== */

    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(ClassSubject::class, 'subject_id');
    // }

    // public function classroom()
    // {
    //     return $this->belongsTo(Classroom::class, 'class_id');
    // }

    // public function stream()
    // {
    //     return $this->belongsTo(Stream::class, 'stream_id');
    // }

    // public function exam()
    // {
    //     return $this->belongsTo(Exam::class, 'exam_id');
    // }
}
