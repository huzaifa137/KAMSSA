<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_type',
        'email',
        'gender',
        'boarding_status',
        'name',
        'registration_code',
        'phone',
        'population',
        'motto',
        'vision',
        'admission_prefix',
        'admission_start',
        'admission_suffix',
        'logo',
    ];

    // public function school()
    // {
    //     return $this->belongsTo(School::class);
    // }
}
