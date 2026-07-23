<?php

namespace App\Services;

use App\Models\Combination;
use App\Models\StudentCombination;
use App\Models\StudentSubjectRegistration;
use Illuminate\Support\Collection;

/**
 * Keeps student_combinations and student_subject_registrations in sync.
 * A student's combination is the single source of truth for which
 * principal subjects they're registered for; compulsory subjects (e.g.
 * General Paper) are untouched here — subject-registration/manage already
 * auto-registers those separately.
 */
class CombinationService
{
    /**
     * Assign (or change) a student's combination for a year, syncing
     * student_subject_registrations to match: subjects belonging only to
     * the OLD combination are removed, subjects belonging only to the NEW
     * one are added. Any optional subject a school registered manually
     * outside of a combination (an extra elective) is left untouched.
     */
    public function setStudentCombination(
        string $studentId,
        int $combinationId,
        string $category,
        string $year,
        string $schoolNumber
    ): StudentCombination {
        $combination = Combination::with('subjects')->findOrFail($combinationId);

        $existing = StudentCombination::where('student_id', $studentId)
            ->where('year', $year)
            ->first();

        $oldSubjectIds = $existing
            ? Combination::with('subjects')->find($existing->combination_id)?->subjects->pluck('md_id') ?? collect()
            : collect();

        $newSubjectIds = $combination->subjects->pluck('md_id');

        // Remove registrations for subjects that were only in the OLD combination.
        $toRemove = $oldSubjectIds->diff($newSubjectIds);
        if ($toRemove->isNotEmpty()) {
            StudentSubjectRegistration::where('student_id', $studentId)
                ->where('year', $year)
                ->whereIn('subject_id', $toRemove)
                ->delete();
        }

        // Add registrations for subjects in the NEW combination.
        foreach ($newSubjectIds as $subjectId) {
            StudentSubjectRegistration::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'year' => $year,
                ],
                [
                    'category' => $category,
                    'is_compulsory' => false,
                    'school_number' => $schoolNumber,
                ]
            );
        }

        return StudentCombination::updateOrCreate(
            ['student_id' => $studentId, 'year' => $year],
            [
                'combination_id' => $combinationId,
                'category' => $category,
                'school_number' => $schoolNumber,
            ]
        );
    }

    /**
     * Remove a student's combination assignment entirely (and the subject
     * registrations that came from it), leaving only compulsory + any
     * manually-added extra electives.
     */
    public function clearStudentCombination(string $studentId, string $year): void
    {
        $existing = StudentCombination::where('student_id', $studentId)->where('year', $year)->first();
        if (!$existing) {
            return;
        }

        $subjectIds = $existing->combination?->subjects->pluck('md_id') ?? collect();
        if ($subjectIds->isNotEmpty()) {
            StudentSubjectRegistration::where('student_id', $studentId)
                ->where('year', $year)
                ->whereIn('subject_id', $subjectIds)
                ->delete();
        }

        $existing->delete();
    }

    /**
     * Find an Active combination for a category by its code, tolerant of
     * case/whitespace (used by the Excel import).
     */
    public function findByCode(string $category, string $code): ?Combination
    {
        $code = strtoupper(trim($code));

        return Combination::where('category', $category)
            ->where('status', 'Active')
            ->whereRaw('UPPER(code) = ?', [$code])
            ->first();
    }

    /**
     * Combination code for a student/year, or null if unassigned — used by
     * the reports module.
     */
    public function codeForStudent(string $studentId, string $year): ?string
    {
        return StudentCombination::where('student_id', $studentId)
            ->where('year', $year)
            ->first()
            ?->combination
                ?->code;
    }

    public function nameForStudent(string $studentId, string $year): ?string
    {
        $sc = StudentCombination::with('combination')
            ->where('student_id', $studentId)
            ->where('year', $year)
            ->first();

        return $sc?->combination?->name;
    }

    /** All Active combinations for a category, with their subjects loaded. */
    public function activeForCategory(string $category): Collection
    {
        return Combination::with('subjects')
            ->where('category', $category)
            ->active()
            ->orderBy('code')
            ->get();
    }
}