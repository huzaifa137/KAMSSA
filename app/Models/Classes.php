<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    // Primary key settings
    protected $primaryKey = 'class_name';
    public $incrementing = false;
    protected $keyType = 'string';

    // No timestamps in your table
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'class',
        'year',
        'term',
        'class_teacher',
        'class_name',
        'Population',
        'Girls',
        'Boys',
        'Stream',
        'Fees',
        'Category',
        'BoardingExtras',
    ];

}
