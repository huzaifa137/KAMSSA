<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAllocation extends Model
{
    protected $table = 'class_allocation';
    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'Student_ID',
        'Class_ID',
        'Comment',
        'HeadTeacher',
        'Warden',
        'Boarding',
    ];

    protected $casts = [
        'Boarding' => 'integer',
    ];
}
