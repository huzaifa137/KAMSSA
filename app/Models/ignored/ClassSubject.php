<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'stream_id',
        'subject_id',
        'subject_type',
        'school_id',
    ];



    // /**
    //  * Get the class-stream assignment that owns the subject.
    //  */
    // public function classStreamAssignment()
    // {
    //     return $this->belongsTo(ClassStreamAssignment::class, 'class_stream_assignment_id');
    // }

    // /**
    //  * Get the actual subject details (assuming you have a 'Subject' model).
    //  */
    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class, 'subject_id'); // Assuming 'Subject' is your subject model
    // }
}