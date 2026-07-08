<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'class_id',
        'stream_id',
        'class_teacher',
        'added_by',
    ];
}
