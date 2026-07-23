<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkPaper extends Model
{
    protected $table = 'mark_papers';

    protected $fillable = [
        'student_id',
        'subject_id',
        'paper_number',
        'raw_mark',
        'max_score',
        'mark',
        'year',
        'category',
        'school_number',
    ];
}