<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUserSchool extends Pivot
{
    protected $table = 'role_user_school';
    protected $fillable = ['user_id', 'role_id', 'school_id'];
}
