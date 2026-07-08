<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'houses';
    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'House',
        'House_AR',
        'Number',
        'Location',
        'RegistrationDate',
        'Head',
        'ContactPerson',
    ];

    protected $casts = [
        'RegistrationDate' => 'datetime',
        'Head' => 'integer',
        'ContactPerson' => 'integer',
    ];

    public function students()
    {
        return $this->hasMany(StudentBasic::class, 'House', 'House');
    }

    public function schoolPassword()
    {
        return $this->hasOne(SchoolPassword::class, 'school_id', 'Number');
    }
}
