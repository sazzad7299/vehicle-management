<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use App\Models\Manufacturer;
use App\Services\ManufacturerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManufacturerController extends Controller
{
    protected $manufacturer;

    public function __construct(ManufacturerService $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    public function index(Request $request)
    {
        $manufacturer = $this->manufacturer->index($request);

        return $this->respondSuccess($manufacturer, 'Manufacturer Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreManufacturerRequest $request, Manufacturer $manufacturer)
    {
        try {
            $this->manufacturer->store($request, $manufacturer);

            return $this->respondCreated($manufacturer, 'Manufacturer Insert Successfully!!!');
        } catch (\Throwable $th) {
            Log::info();

            return $this->respondError('Manufacturer Insert Failed');
        }
    }

    public function show(Manufacturer $manufacturer)
    {

        return $this->respondSuccess($manufacturer, 'Manufacturer Retrieved Successfully');
    }

    public function edit(Manufacturer $manufacturer)
    {

    }

    public function update(UpdateManufacturerRequest $request, Manufacturer $manufacturer)
    {
        try {
            $this->manufacturer->update($request, $manufacturer);

            return $this->respondCreated($manufacturer, 'Manufacturer Update Successfully!!!');
        } catch (\Throwable $th) {
            return $this->respondError('Something Went wrong,Try Again!');
        }
    }

    public function destroy(Manufacturer $manufacturer)
    {
        try {
            $this->manufacturer->delete($manufacturer);

            return $this->respondDelete('Manufacturer Deleted Successfully');
        } catch (\Throwable $th) {
            return $this->respondError('Something Went wrong,Try Again!');
        }
    }

    public function trash(Request $request)
    {
        $data = Manufacturer::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Manufacturer::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Manufacturer::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
