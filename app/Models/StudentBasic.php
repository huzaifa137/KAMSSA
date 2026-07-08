<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBasic extends Model
{
    protected $table = 'students_basic';

    protected $primaryKey = 'Student_ID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false; // since table has no created_at / updated_at

    protected $fillable = [
        'Student_ID',
        'Student_Name',
        'Date_of_Birth',
        'Student_Name_AR',
        'StudentSex_AR',
        'District_AR',
        'MothersJob',
        'Disabilities',
        'ChronicleDiseases',
        'Birth_Place',
        'Birth_Place_AR',
        'Date_of_Birth_AR',
        'StudentsAddress',
        'FathersAddress',
        'MothersAddress',
        'GuardianAddress',
        'Fatherscontact',
        'MothersContact',
        'EntryDate',
        'GuardiansContact',
        'GuardiansJob',
        'FathersNationality',
        'MothersNationality',
        'GuardiansNationality',
        'StudentsNationality',
        'StudentsCitizenship',
        'FathersCitizenship',
        'MothersCitizenship',
        'GuardiansCitizenship',
        'StudentSex',
        'StudentSurname',
        'StudentFirstname',
        'OtherNames',
        'GuardianRelationship',
        'GuardianName',
        'IsOrphan',
        'admnno',
        'admnyr',
        'admncl',
        'FatherStatus',
        'MotherStatus',
        'Photo',
        'District',
        'Class',
        'Section',
        'Class_AR',
        'state',
        'classid',
        'House',
        'ID_AR',
        'SNO'
    ];


    // Relationship with House
    public function house()
    {
        return $this->belongsTo(House::class, 'House', 'House');
    }
}
