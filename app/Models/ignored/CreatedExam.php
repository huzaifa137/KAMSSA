<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatedExam extends Model
{
    use HasFactory;

    protected $table = 'created_exams';

    protected $fillable = [
        'ce_exam_name',
        'ce_term',
        'ce_class_ids',
        'ce_exam_year',
        'ce_created_by',
        'ce_exam_status',
        'ce_date_created'
    ];

    protected $casts = [
        'ce_class_ids' => 'array',
    ];
}
