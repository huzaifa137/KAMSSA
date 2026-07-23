<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCombination extends Model
{
    protected $fillable = [
        'student_id',
        'combination_id',
        'category',
        'year',
        'school_number',
    ];

    public function combination(): BelongsTo
    {
        return $this->belongsTo(Combination::class);
    }
}