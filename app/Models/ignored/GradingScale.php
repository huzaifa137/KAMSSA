<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingScale extends Model
{
    use HasFactory;

    // Table associated with the model (optional if the table name follows Laravel's convention)
    protected $table = 'grading_scales';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'min_mark',
        'max_mark',
        'grade',
        'points',
    ];

    // Optionally, cast points to integer if needed
    protected $casts = [
        'points' => 'integer',
    ];
}
