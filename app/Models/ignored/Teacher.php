<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'surname',
        'firstname',
        'email',
        'password',
        'othername',
        'email',
        'password',
        'initials',
        'phonenumber',
        'registration_number',
        'gender',
        'national_id',
        'address',
        'employee_number',
        'group_teacher',
        'teacher_profile',
    ];

    // public function school()
    // {
    //     return $this->belongsTo(School::class);
    // }
}
