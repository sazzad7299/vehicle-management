<?php

namespace App\Http\Controllers\API\V1\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedInUserWithRoles = auth('sanctum')->user()->load('roles');
        // dd($loggedInUserWithRoles);
        $pharmacyId = auth('sanctum')->user()->pharmacy_id;

        if (auth('sanctum')->user()->hasPermission('user') || auth('sanctum')->user()->hasPermission('user.index')) {
            $user = User::query()
                ->when(request()->get('search'), function ($query) {
                    return $query->search(request()->get('search'));
                })
                ->when($loggedInUserWithRoles->roles->contains('name', 'super-admin') || $loggedInUserWithRoles->roles->contains('name', 'admin'), function ($query) {
                    return $query; // Show all users for super-admin and admin
                })
                ->when($pharmacyId !== null, function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                })
                ->when($pharmacyId === null, function ($query) {
                    return $query;
                })
                ->with(['pharmacy:id,company_name', 'roles:id,name'])
                ->paginate(request()->get('per_page', 10));

            return $this->respondSuccess($user, 'User Retrieved Successfully');
        } else {
            return $this->respondUnAuthorized();
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function AccessAvailable(Request $request)
    {
        $model = $request->model;
        if (hasExceededQuota($model)) {
            return $this->respondExpireLimit();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, User $user)
    {
        if (hasExceededQuota(get_class($user))) {
            return $this->respondExpireLimit();
        }
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            if (empty($data['pharmacy_id'])) {
                $data['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            }

            $image = $request->image;
            if ($image) {
                $data['image'] = $this->base64FileStore($image, 'images/user/', Str::slug($request->name));
            }
            $user->fill($data)->save();
            if ($data['role_id']) {
                $role = Role::query()->where('id', $data['role_id'])->first();
            } else {
                $role = Role::query()->where('name', 'worker')->first();
            }
            $user->roles()
                ->attach(
                    $role->id,
                    [
                        'model_type' => get_class($user),
                    ]);

            DB::commit();

            return $this->respondCreated($user, 'User Created Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->respondError($e->getMessage());
        }
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
    public function edit(User $user)
    {
        $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
        $user = [
            'id' => (int) $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'pharmacy_id' => (int) $user->pharmacy_id,
            'country_id' => (int) $user->country_id,
            'division_id' => (int) $user->division_id,
            'district_id' => (int) $user->district_id,
            'upazilas_id' => (int) $user->upazilas_id,
            'union_id' => (int) $user->union_id,
            'zip_code' => $user->zip_code,
            'role_id' => $role->role_id,
            'email' => $user->email,
            'image' => $user->image,
            'user_status' => $user->user_status,
        ];

        return $this->respondSuccess($user, 'User Retrieved Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $image = $request->image;
            if ($image) {
                if (file_exists($user->image)) {
                    unlink($user->image);
                }
                $data['image'] = $this->base64FileStore($image, 'images/users/', $request->name);
            } else {
                $data = Arr::except($data, ['image']);
            }
            if ($data['user_status'] == false) {
                $data['user_status'] = 0;
            }
            $user->fill($data)->save();
            $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
            if ($data['role_id'] !== $role->role_id) {
                $user->roles()->detach();
                $user->roles()
                    ->attach(
                        $data['role_id'],
                        [
                            'model_type' => get_class($user),
                        ]);
            }
            DB::commit();

            return $this->respondCreated($user, 'User Updated Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
