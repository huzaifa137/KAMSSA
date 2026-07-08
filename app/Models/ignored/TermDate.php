<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermDate extends Model
{
    protected $fillable = [
        'school_id',
        'academic_year_id',
        'term',
        'start_date',
        'end_date',
        'week_starts_on',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
