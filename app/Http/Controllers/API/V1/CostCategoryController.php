<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostCategoryRequest;
use App\Http\Requests\UpdateCostCategoryRequest;
use App\Models\CostCategory;
use Illuminate\Http\Request;

class CostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = CostCategory::query()->pharmacy()->active()->search($request)->get();

        return response()->json($data, 200);
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
    public function store(StoreCostCategoryRequest $request, CostCategory $costCategory)
    {
        try {
            $requestedData = $request->all();
            $costCategory->fill($requestedData)->save();

            return response()->json('Insert Successfully!!!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CostCategory $costCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostCategory $costCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostCategoryRequest $request, CostCategory $costCategory)
    {
        try {
            $requestedData = $request->all();
            $costCategory->fill($requestedData)->save();

            return response()->json('Updated successfully!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostCategory $costCategory)
    {
        $costCategory->delete();

        return response()->json('Deleted successfully!');
    }

    public function trash(Request $request)
    {
        $data = CostCategory::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        CostCategory::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        CostCategory::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
