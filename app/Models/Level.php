<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';
    protected $primaryKey = 'ID';

    public $incrementing = false;   // IMPORTANT (varchar PK)
    protected $keyType = 'string';  // IMPORTANT

    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Level',
        'Available',
        'Level_ar',
    ];

    protected $casts = [
        'Available' => 'boolean',
    ];
}
