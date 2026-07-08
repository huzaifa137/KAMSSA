<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  protected $fillable = [
    'firstname',
    'lastname',
    'senior',
    'stream',
    'gender',
    'school_id',
    'admission_number',
    'primary_contact',
    'other_contact',
    'student_photo',
    'date_of_admission',
    'ple_score',
    'uce_score',
    'previous_school',
    'primary_school_name',
    'guardian_names',
    'relation',
    'guardian_phone',
    'guardian_email',
    'home_address',
    'date_of_birth',
    'place_of_birth',
    'birth_certificate_entry_number',
    'nationality',
    'medical_history',
    'comments',
    'added_by',
  ];

  // public function school()
  // {
  //   return $this->belongsTo(School::class);
  // }


}
