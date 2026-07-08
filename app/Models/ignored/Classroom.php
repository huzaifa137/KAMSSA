<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_name',
        'class_supervisor' 
    ];


    // public function school()
    // {
    //     return $this->belongsTo(School::class);
    // }
}
