<?php
// app/Models/StudentResult.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'year',
        'category',
        'school_number',
        'total_marks',
        'percentage',
        'grade',
        'classification',
        'level'
    ];

    public function student()
    {
        return $this->belongsTo(ClassAllocation::class, 'student_id', 'Student_ID');
    }
}