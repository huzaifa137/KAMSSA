<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectPaper extends Model
{
    protected $table = 'subject_papers';

    protected $fillable = [
        'subject_id',
        'paper_number',
        'max_score',
    ];
}