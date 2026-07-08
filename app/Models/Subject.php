<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $primaryKey = 'ID';

    public $timestamps = false; // no created_at / updated_at columns

    protected $fillable = [
        'PaperCode',
        'Level',
        'Category',
        'CategoryName',
        'subject',
        'SubjectCode',
        'PaperName',
        'SchoolCategory',
        'SUBJECT_AR',
        'PAPER_AR'
    ];

}
