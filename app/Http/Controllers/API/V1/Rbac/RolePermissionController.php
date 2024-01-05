<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all();
        $permitted_permissions = $role->permissions->pluck('id')->toArray();
        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'permitted_permissions' => $permitted_permissions,
        ];

        return $this->respondSuccess($data, 'Permissions Retrieved Successfully');
    }
}
