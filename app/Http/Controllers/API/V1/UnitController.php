<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $unit;

    public function __construct(UnitService $unit)
    {
        $this->unit = $unit;
    }

    public function index(Request $request)
    {
        $unit = $this->unit->index($request);

        return $this->respondSuccess($unit, 'Unit Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreUnitRequest $request, Unit $unit)
    {
        try {
            $requestedData = $request->all();
            if ($requestedData['status'] === true) {
                $requestedData['status'] = 1;
            }
            $unit->fill($requestedData)->save();

            return $this->respondCreated($unit, 'Unit Insert Successfully!!!');
        } catch (\Throwable$e) {
            return $this->respondError($e, 'Unit Insert Failed');
        }
    }

    public function show(Unit $unit)
    {
        //
    }

    public function edit(Unit $unit)
    {
        //
    }

    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $requestedData = $request->all();
            if ($requestedData['status'] === true) {
                $requestedData['status'] = 1;
            }
            $unit->fill($requestedData)->save();

            return $this->respondSuccess($unit, 'Unit Updated Successfully!!!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return $this->respondDelete('Unit Deleted Successfully');
    }

    public function trash(Request $request)
    {
        $data = Unit::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Unit::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Unit::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
