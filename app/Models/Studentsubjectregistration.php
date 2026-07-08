<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class StudentSubjectRegistration extends Model
{
    protected $table = 'student_subject_registrations';

    protected $fillable = [
        'student_id',
        'subject_id',
        'category',
        'year',
        'is_compulsory',
        'school_number',
    ];

    protected $casts = [
        'is_compulsory' => 'boolean',
    ];

    public function subject()
    {
        return $this->belongsTo(MasterData::class, 'subject_id', 'md_id');
    }

    /**
     * Distinct subject_ids registered by any of the given students for a year.
     */
    public static function subjectIdsForStudents(array $studentIds, string $year): Collection
    {
        if (empty($studentIds)) {
            return collect();
        }

        return self::whereIn('student_id', $studentIds)
            ->where('year', $year)
            ->distinct()
            ->pluck('subject_id');
    }

    /**
     * Map of subject_id => Collection of student_ids registered for it,
     * scoped to the given students/year. Useful for building the
     * "who takes this subject" list per column when rendering the
     * marks-entry grid.
     */
    public static function registrationMap(array $studentIds, string $year): Collection
    {
        if (empty($studentIds)) {
            return collect();
        }

        return self::whereIn('student_id', $studentIds)
            ->where('year', $year)
            ->get()
            ->groupBy('subject_id')
            ->map(function ($rows) {
                return $rows->pluck('student_id')->flip(); // student_id => index, for fast isset() checks
            });
    }

    /**
     * How many subjects a specific student is registered for in a year
     * (used to compute that student's own "out of X subjects" total).
     */
    public static function countForStudent(string $studentId, string $year): int
    {
        return self::where('student_id', $studentId)->where('year', $year)->count();
    }
}