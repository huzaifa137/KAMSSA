<?php
namespace App\Models;

use App\Models\Role;
use App\Models\House;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'temp_otp',
        'user_role',
        'user_status',
        'procurement_approval_status',
        'firstname',
        'lastname',
        'gender',
        'phonenumber',
        'user_id',
        'account_status',
        'supervisor',
        'title',
        'user_supervisor',
        'user_title',
        'procurement_year',
        'user_reference',
        'user_last_active',
        'user_signature',
        'passport_number',
        'profile_id',
        'country',
        'is_active',
        'system_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user_school')
            ->withPivot('school_id')
            ->withTimestamps();
    }

    public function schools()
    {
        return $this->belongsToMany(House::class, 'role_user_school', 'user_id', 'school_id')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function getRolesForSchool($schoolId)
    {
        return $this->roles()->wherePivot('school_id', $schoolId)->get();
    }

    public function hasPermission($permissionName, $schoolId)
    {
        return $this->roles()
            ->wherePivot('school_id', $schoolId)
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })->exists();
    }

    /*
    |--------------------------------------------------------------------
    | Marks Entrant scoping
    |--------------------------------------------------------------------
    | A "marks entrant" is a restricted admin account (user_role = 'admin',
    | system_role = 'marks_entrant') that may only enter marks for the
    | subjects/papers explicitly assigned to it. Regular admins have
    | system_role = null and are unaffected by any of this.
    */

    public function markAssignments()
    {
        return $this->hasMany(MarksEntrantAssignment::class, 'user_id');
    }

    public function isMarksEntrant(): bool
    {
        return $this->system_role === 'marks_entrant';
    }

    /**
     * Distinct list of subject_ids (master_datas.md_id) this entrant may
     * touch in any paper.
     */
    public function allowedSubjectIds(): array
    {
        return $this->markAssignments()->distinct()->pluck('subject_id')->all();
    }

    /**
     * Paper numbers this entrant may capture for a given subject.
     * Returns an empty array if the subject isn't assigned at all.
     */
    public function allowedPapersForSubject($subjectId): array
    {
        return $this->markAssignments()
            ->where('subject_id', $subjectId)
            ->pluck('paper_number')
            ->all();
    }

    public function isAllowedSubjectPaper($subjectId, $paperNumber): bool
    {
        return $this->markAssignments()
            ->where('subject_id', $subjectId)
            ->where('paper_number', $paperNumber)
            ->exists();
    }
}