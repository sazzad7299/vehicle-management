<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $customer;
    // protected $pharmacyId;

    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
        // $this->pharmacyId = auth('sanctum')->user()->pharmacy_id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cutomer = $this->customer->index($request);

        return $this->respondSuccess($cutomer, 'Customer Retrieved Successfully');
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
    public function store(StoreCustomerRequest $request, Customer $customer)
    {
        // return $request->all();
        try {
            DB::beginTransaction();
            if (! empty(auth('sanctum')->user()->pharmacy_id)) {
                $request['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            }
            $customer = $this->customer->store($request, $customer);
            DB::commit();

            return $this->respondCreated($customer, 'Customer Created Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer = $this->customer->show($customer);

        return $this->respondSuccess($customer, 'Customer Details Retrive');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // $this->customer->store($request, $customer);
        try {
            if (auth('sanctum')->user()->pharmacy_id == $customer->pharmacy_id && $customer->name !== 'Walking Customer') {
                $this->customer->update($request, $customer);

                return $this->respondSuccess($customer, 'Customer Updated Successfully');
            } else {
                return $this->respondSuccess(null, "You Can't Delete this customer");
            }
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer) {
            if (auth('sanctum')->user()->pharmacy_id == $customer->pharmacy_id && $customer->name !== 'Walking Customer') {

                $customer->delete();

                return $this->respondDelete('Customer Deleted Successfully');
            } else {
                return $this->respondDelete("This customer Can't Deletabel");
            }
        } else {
            return $this->respondNotFound('Customer Not Found');
        }
    }

    public function trash(Request $request)
    {
        $data = Customer::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Customer::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        $data = Customer::pharmacy()->findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!!!');
    }
}
