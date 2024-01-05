<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::query()
            ->when(request()->get('search'), function ($query) {
                $query->search(request()->get('search'));
            })
            ->when(auth()->user()->pharmacy_id != null, function ($query) {
                $query->where('access_by', 0)->where('status', 1);
            })
            ->paginate($request->get('per_page', 10))->through(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => Str::title($role->name),
                ];
            });

        return $this->respondSuccess($roles, 'Roles Retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, Role $role)
    {
        $role->fill($request->validated())->save();

        return $this->respondCreated(null, 'Role Created Successfully');
    }

    public function edit(Role $role)
    {
        return $this->respondSuccess($role, 'Role Retrieved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->respondSuccess($role, 'Role Retrieved Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->fill($request->validated())->save();

        return $this->respondSuccess(null, 'Role Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->respondSuccess(null, 'Role Deleted Successfully');
    }

    public function get_roles()
    {
        $role = Role::query();
        if (auth()->user()->pharmacy_id) {
            $role->where('access_by', 0)->where('status', 1);
        }
        $roles = $role->get();

        return $this->respondSuccess($roles, 'Roles Retrieved Successfully');
    }
}
