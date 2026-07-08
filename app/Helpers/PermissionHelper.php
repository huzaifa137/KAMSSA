<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PermissionHelper
{

    public static function userHasSpecificPermission($userId, $permissionFeature, $permissionName, $permissionScope)
    {
        $userRoles = DB::table('role_user_school')
            ->where('user_id', $userId)
            ->pluck('role_id')
            ->toArray();

        if (empty($userRoles)) {
            return false;
        }

        $exists = DB::table('permissions')
            ->whereIn('role_id', $userRoles)
            ->where('feature', $permissionFeature)
            ->where('name', $permissionName)
            ->where('scope', $permissionScope)
            ->where('is_marked', 1)
            ->exists();

        return $exists;
    }


    public static function userHasAllPermissions($userId, $permissionName, $permissionScope)
    {
        $userRoles = DB::table('role_user_school')
            ->where('user_id', $userId)
            ->pluck('role_id')
            ->toArray();

        if (empty($userRoles)) {
            return false;
        }

        $results = DB::table('permissions')
            ->whereIn('role_id', $userRoles)
            ->where('name', $permissionName)
            ->where('scope', $permissionScope)
            ->select('role_id', 'is_marked')
            ->get();

        $groupedByRole = $results->groupBy('role_id');

        foreach ($groupedByRole as $roleId => $permissions) {
            if ($permissions->every(fn($perm) => $perm->is_marked == 1)) {
                return true;
            }
        }
        return false;
    }



    public static function userPermissionSectionAccess($userId, $permissionName, $permissionScope)
    {
        $results = DB::table('role_user_school')
            ->join('permission_role', 'role_user_school.role_id', '=', 'permission_role.role_id')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.name')
            ->where('role_user_school.user_id', $userId)
            ->where('permissions.name', $permissionName)
            ->where('permissions.scope', $permissionScope)
            ->exists();

        return $results;
    }

}
