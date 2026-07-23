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
        'school_status',
        'email',
        'phone',
        'school_type',
        'gender',
        'regional_level',
        'school_ownership',
        'boarding_status',
        'school_product',
        'population',
        'motto',
        'vision',
        'admission_prefix',
        'admission_start',
        'admission_suffix',
        'logo',
        'administrator_names',
        'administrator_telephones',
        'title',
        'category',
        'district',
    ];

    protected $appends = ['id', 'name', 'registration_code', 'date_added'];

    public function getIdAttribute()
    {
        return $this->attributes['ID'] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->House;
    }

    public function getRegistrationCodeAttribute()
    {
        return $this->Number;
    }

    public function getDateAddedAttribute()
    {
        return $this->RegistrationDate;
    }

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