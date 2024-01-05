<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })->latest();
        if ($request->has('paginate')) {
            $categories = $category->select(['id', 'name'])->get();

        } else {
            $categories = $category->paginate(request()->get('per_page', 10));
        }

        return $this->respondSuccess($categories, 'Department Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request, Category $category)
    {

        try {
            $requestedData = $request->all();
            if (! empty($requestedData['status'])) {
                $requestedData['status'] == 1;
            }
            $category->fill($requestedData)->save();

            return $this->respondCreated('Department Updated Successfully');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'Department Updated Successfully');

        }
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {

        try {
            $requestedData = $request->all();
            $category->fill($requestedData)->save();

            return response()->json('Updated successfully!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json('Deleted successfully!');
    }

    public function trash(Request $request)
    {
        $data = Category::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Category::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Category::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
