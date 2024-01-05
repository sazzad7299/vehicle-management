<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashInOutRequest;
use App\Http\Requests\UpdateCashInOutRequest;
use App\Models\CashInOut;
use App\Services\CashInOutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashInOutController extends Controller
{
    protected $balanceService;

    public function __construct(CashInOutService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    public function index(Request $request)
    {

        $balance = $this->balanceService->index($request);

        return $this->respondSuccess($balance, 'Payment Methods Retrieved Successfully');
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
    public function store(StoreCashInOutRequest $request, CashInOut $cashInOut)
    {
        try {
            DB::beginTransaction();
            $request['pharmacy_id'] = auth()->user()->pharmacy_id;
            $cash = $this->balanceService->store($request, $cashInOut);
            DB::commit();

            return $this->respondSuccess($cash, 'Data Store Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CashInOut $cashInOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashInOut $cashInOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashInOutRequest $request, CashInOut $balance_info)
    {
        try {

            $requestedData = $request->all();
            $cash = $this->balanceService->update($requestedData, $balance_info);

            return $this->respondSuccess($cash, 'Data Update Successfully');
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashInOut $balance_info)
    {
        try {

            $this->balanceService->delete($balance_info);

            return $this->respondDelete('Leaf Deleted Successfully');
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    public function trash(Request $request)
    {
        $data = CashInOut::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        CashInOut::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        CashInOut::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
