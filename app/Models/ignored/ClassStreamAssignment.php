<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStreamAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'stream_id',
    ];


    // public function classSubjects()
    // {
    //     return $this->hasMany(ClassSubject::class, 'class_stream_assignment_id');
    // }


    // If you have Class and Stream models, you can define relationships here
    // public function class()
    // {
    //     return $this->belongsTo(Class::class);
    // }

    // public function stream()
    // {
    //     return $this->belongsTo(Stream::class);
    // }
}