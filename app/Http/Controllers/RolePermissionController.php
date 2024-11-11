<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function store($role_id, $permission_id)
    {
        $role_permissions = RolePermission::where('role_id', $role_id)->pluck('permission_id')->toArray();

        if (($index = array_search($permission_id, $role_permissions)) !== false) {
            RolePermission::where('role_id', $role_id)
                ->where('permission_id', $permission_id)
                ->delete();
        } else {
            RolePermission::create([
                'role_id'       => $role_id,
                'permission_id' => $permission_id,
            ]);
        }
        return response()->json([
            'success' => get_phrase('Permission has been updated.'),
        ]);
    }
}
