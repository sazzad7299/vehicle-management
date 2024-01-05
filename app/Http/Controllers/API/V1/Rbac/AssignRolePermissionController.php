<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Models\RoleHasPermission;
use Exception;
use Illuminate\Http\Request;

class AssignRolePermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function singlePermission(Request $request)
    {
        try {
            $check_prev_perm = RoleHasPermission::query()->where('permission_id', $request->permission_id)
                ->where('role_id', $request->role_id)
                ->first();

            if ($check_prev_perm) {
                RoleHasPermission::query()->where('permission_id', $request->permission_id)
                    ->where('role_id', $request->role_id)
                    ->delete();

                return $this->respondSuccess(null, 'Permission Removed');
            } else {
                $new_permit = new RoleHasPermission;
                $new_permit->permission_id = $request->permission_id;
                $new_permit->role_id = $request->role_id;
                $new_permit->save();

                return $this->respondCreated($new_permit, 'Permission Granted');
            }
        } catch (Exception $e) {
            return $this->respondError($e->getMessage(), (int) $e->getCode());
        }
    }

    public function assignMultipleRolePermissions(Request $request)
    {
        try {
            $role_id = $request->input('role_id');
            $permission_ids = $request->input('selectedIds');
            $remove_ids = $request->input('deselectedIds');
            foreach ($remove_ids as $id) {
                RoleHasPermission::query()->where('permission_id', $id)
                    ->where('role_id', $role_id)
                    ->delete();
            }
            foreach ($permission_ids as $permission_id) {
                $check_prev_perm = RoleHasPermission::query()->where('permission_id', $permission_id)
                    ->where('role_id', $role_id)
                    ->first();

                if ($check_prev_perm) {
                } else {
                    $new_permit = new RoleHasPermission;
                    $new_permit->permission_id = $permission_id;
                    $new_permit->role_id = $role_id;
                    $new_permit->save();
                }
            }

            return $this->respondSuccess($role_id, 'Role Permissions Updated');
        } catch (Exception $e) {
            return $this->respondError($e->getMessage(), (int) $e->getCode());
        }
    }
}
