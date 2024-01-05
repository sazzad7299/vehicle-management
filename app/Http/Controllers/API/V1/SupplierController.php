<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $supplier;

    public function __construct(SupplierService $supplier)
    {
        $this->supplier = $supplier;
        // $this->pharmacyId = auth('sanctum')->user()->pharmacy_id;
    }

    public function index(Request $request)
    {
        $supplier = $this->supplier->index($request);

        return $this->respondSuccess($supplier, 'Supplier Retrieved Successfully');
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
    public function store(StoreSupplierRequest $request, Supplier $supplier)
    {
        if (hasExceededQuota(get_class($supplier))) {
            return $this->respondExpireLimit();
        }
        try {
            DB::beginTransaction();
            if (! empty(auth('sanctum')->user()->pharmacy_id)) {
                $request['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            }
            $this->supplier->store($request, $supplier);
            DB::commit();

            return $this->respondCreated(null, 'Supplier Created Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplier = $this->supplier->show($supplier);

        return $this->respondSuccess($supplier, 'Supplier Details Retrive');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {

        return $this->respondSuccess($supplier, 'Supplier Details Retrive');
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            $this->supplier->update($request, $supplier);

            return $this->respondSuccess($supplier, 'Supplier Updated Successfully');
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return $this->respondSuccess($supplier, 'Supplier Deleted Successfully');
    }

    public function trash(Request $request)
    {
        $data = Supplier::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Supplier::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        $data = Supplier::pharmacy()->findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!!!');
    }
}
