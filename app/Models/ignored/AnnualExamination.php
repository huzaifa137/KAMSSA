<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualExamination extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'examination_name',
        'examination_classification',
        'year',
        'is_active',
    ];

    // Casts for proper data types
    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
    ];
}
