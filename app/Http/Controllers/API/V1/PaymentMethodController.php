<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    protected $payment_method;

    public function __construct(PaymentMethodService $payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function index(Request $request)
    {

        $payment_method = $this->payment_method->index($request);

        return $this->respondSuccess($payment_method, 'Payment Methods Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StorePaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        try {
            $this->payment_method->store($request, $payment_method);

            return $this->respondCreated($payment_method, 'Payment Method Insert Successfully!!!');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        try {
            $this->payment_method->update($request, $payment_method);

            return $this->respondSuccess($payment_method, 'Payment Method Updated Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'Payment Method Update Failed');
        }
    }

    public function destroy(PaymentMethod $payment_method)
    {
        try {
            $this->payment_method->delete($payment_method);

            return $this->respondDelete('Payment Method Deleted Successfully');
        } catch (\Throwable $th) {
            return $this->respondError('Something Went wrong,Try Again!');
        }
    }

    public function trash(Request $request)
    {
        $data = PaymentMethod::query()->search($request)->active()->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        PaymentMethod::where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        PaymentMethod::where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }

    public function currentBalance()
    {
        $balance = $this->payment_method->current_balance();

        return $this->respondSuccess($balance, 'Retrive Current Balance with Payment Method');
    }
}
