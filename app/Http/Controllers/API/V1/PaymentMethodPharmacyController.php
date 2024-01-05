<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentMethodPharmacyRequest;
use App\Http\Requests\UpdatePaymentMethodPharmacyRequest;
use App\Models\PaymentMethodPharmacy;

class PaymentMethodPharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PaymentMethodPharmacy::query()->pharmacy()->active()->get();

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
    public function store(StorePaymentMethodPharmacyRequest $request, PaymentMethodPharmacy $paymentMethodPharmacy)
    {
        try {
            $requestedData = $request->all();
            $paymentMethodPharmacy->fill($requestedData)->save();

            return response()->json('Insert Successfully!!!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethodPharmacy $paymentMethodPharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethodPharmacy $paymentMethodPharmacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodPharmacyRequest $request, PaymentMethodPharmacy $paymentMethodPharmacy)
    {
        try {
            $requestedData = $request->all();
            $paymentMethodPharmacy->fill($requestedData)->save();

            return response()->json('Updated successfully!');
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethodPharmacy $paymentMethodPharmacy)
    {
        //
    }
}
