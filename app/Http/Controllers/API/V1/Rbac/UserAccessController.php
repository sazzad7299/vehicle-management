<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAccessRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->withWhereHas('roles')
            ->paginate(request()->get('per_page', 10))
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->map(function ($role) {
                        return [
                            'id' => $role->id,
                            'name' => Str::title($role->name),
                        ];
                    }),
                ];
            });
        $roles = Role::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => Str::title($role->name),
            ];
        });
        $data = [
            'users' => $users,
            'roles' => $roles,
        ];

        return $this->respondSuccess($data, 'Users and Roles Retrieved Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $roles = Role::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => Str::title($role->name),
            ];
        });
        $data = [
            'users' => $users,
            'roles' => $roles,
        ];

        return $this->respondSuccess($data, 'Users and Roles Retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAccessRequest $request)
    {
        //        $user = User::find($request->user_id);
        //        $user->roles()->sync($request->role_id);
        $user = User::find($request->user_id);
        $user->roles()
            ->sync([
                $request->role_id => [
                    'model_type' => 'App\Models\User',
                    'model_id' => $request->user_id,
                ],
            ]);

        return $this->respondCreated(null, 'User Access Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
