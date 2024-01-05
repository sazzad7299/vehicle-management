<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchasePaymentRequest;
use App\Models\PurchasePayment;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    protected $purchase;

    public function __construct(PurchaseService $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchase_payment = $this->purchase->payments($request);

        return $this->respondSuccess(['payment' => $purchase_payment, 'filter' => $request->all()], 'Payment Retrieved Successfully');
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
    public function store(StorePurchasePaymentRequest $request)
    {

        $paymentinfo = $request->all();
        // return $paymentinfo;
        $payment = $this->purchase->purchasePayment($paymentinfo);

        return $this->respondCreated($payment, 'Purchase Due Update Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchasePayment $purchasePayment)
    {
        //
    }
}
