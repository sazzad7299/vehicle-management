<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetPermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth('sanctum')->user();
        $user->load('roles.permissions');
        $permissions = $user->roles->pluck('permissions')->flatten()->pluck('name')->unique()->toArray();

        return $this->respondSuccess($permissions, 'Permissions Retrieved Successfully');
    }
}
