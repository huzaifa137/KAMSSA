<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'ExamDate',
        'Venue',
        'ETime',
        'Class',
        'PaperCode',
        'Duration',
        'ExamFile',
        'Facilitator',
        'ExTime',
        'Weight',
        'GenClass',
        'ExamType',
        'Status',
        'Stream',
        'AssesmentTitle',
        'ExamDate_Ar',
    ];

    protected $casts = [
        'ExamDate' => 'date',
        'Duration' => 'float',
        'Weight' => 'float',
        'Status' => 'boolean',
    ];
}
