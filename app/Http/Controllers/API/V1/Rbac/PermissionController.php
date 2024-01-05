<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->when(request()->get('search'), function ($query) {
                $query->search(request()->get('search'));
            })
            ->paginate($request->get('per_page', 10));

        return $this->respondSuccess($permissions, 'Roles Retrieved Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request, Permission $permission)
    {
        try {
            $permission->fill($request->validated())->save();

            return $this->respondCreated(null, 'Permission Created Successfully');
        } catch (\Throwable $e) {
            return $this->respondError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return $this->respondSuccess($permission, 'Permission Retrieved Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $requestedData = $request->all();
            $permission->fill($requestedData)->save();

            return response()->json('Updated successfully!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json('Deleted successfully!');
    }

    public function trash(Request $request)
    {
        $data = Permission::query()->search($request)->active()->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Permission::where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Permission::where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
