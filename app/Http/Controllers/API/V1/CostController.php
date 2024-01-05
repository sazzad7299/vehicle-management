<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Models\Cost;
use App\Services\CostService;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $costService;

    public function __construct(CostService $costService)
    {
        $this->costService = $costService;
    }

    public function index(Request $request)
    {
        $cost = $this->costService->index($request);

        return $this->respondSuccess(['cost' => $cost, 'filter' => $request->all()], 'Cost Retrieved Successfully');
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
    public function store(StoreCostRequest $request, Cost $cost)
    {
        try {
            $cost = $this->costService->store($request, $cost);

            return $this->respondSuccess($cost, 'Cost Insert Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th, 'Sorry! Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostRequest $request, Cost $cost)
    {
        try {
            $cost = $this->costService->update($request, $cost);

            return $this->respondSuccess($cost, 'Cost Updated Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th, 'Sorry! Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        try {

            $this->costService->delete($cost);

            return $this->respondDelete('Cost Deleted Successfully');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'Sorry! Something went wrong');
        }
    }

    public function trash(Request $request)
    {
        $data = Cost::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Cost::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        $data = Cost::pharmacy()->findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!!!');
    }
}
