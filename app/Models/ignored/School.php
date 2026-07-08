<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'school_type',
        'email',
        'gender',
        'regional_level',
        'school_ownership',
        'boarding_status',
        'name',
        'school_product',
        'registration_code',
        'phone',
        'population',
        'added_by',
        'date_added',
    ];

    // public function classrooms()
    // {
    //     return $this->hasMany(Classroom::class);
    // }

}
