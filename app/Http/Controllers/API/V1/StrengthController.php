<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStrengthRequest;
use App\Http\Requests\UpdateStrengthRequest;
use App\Models\Strength;
use Illuminate\Http\Request;

class StrengthController extends Controller
{
    public function index(Request $request)
    {
        $data = Strength::query()->pharmacy()->active()->search($request)->get();

        return response()->json($data, 200);
    }

    public function create()
    {
        //
    }

    public function store(StoreStrengthRequest $request, Strength $strength)
    {
        try {
            $requestedData = $request->all();
            $strength->fill($requestedData)->save();

            return response()->json('Insert Successfully!!!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    public function show(Strength $strength)
    {
        //
    }

    public function edit(Strength $strength)
    {
        //
    }

    public function update(UpdateStrengthRequest $request, Strength $strength)
    {
        try {
            $requestedData = $request->all();
            $strength->fill($requestedData)->save();

            return response()->json('Updated successfully!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    public function destroy(Strength $strength)
    {
        $strength->delete();

        return response()->json('Deleted successfully!');
    }

    public function trash(Request $request)
    {
        $data = Strength::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Strength::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Strength::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
