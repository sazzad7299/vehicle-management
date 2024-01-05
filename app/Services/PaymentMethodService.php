<?php

namespace App\Services;

use App\Models\CashInOut;
use App\Models\Cost;
use App\Models\EmployeeSalary;
use App\Models\PaymentMethod;
use App\Models\PurchaseReturn;
use App\Models\SaleReturn;

class PaymentMethodService
{
    public function index($request)
    {
        $payment_method = PaymentMethod::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $payment_method->select(['id', 'name'])->get();
        } else {
            return $payment_method->paginate(request()->get('per_page', 10));
        }

        return $payment_method;
    }

    public function store($request, $payment_method)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        if (! empty(auth('sanctum')->user()->pharmacy_id)) {
            $requestedData['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
        }
        $payment_method->fill($requestedData)->save();

        return $payment_method;
    }

    public function update($request, $payment_method)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $payment_method->fill($requestedData)->save();

        return $payment_method;
    }

    public function delete($payment_method)
    {

        $payment_method->delete();
    }

    public function current_balance()
    {
        $paymentMethods = PaymentMethod::withSum('purchasePayments', 'paid')
            ->withSum('salePayments', 'paid')
            ->get(['id', 'name']);

        $payment_method = [];

        foreach ($paymentMethods as $paymentMethod) {
            $cashInSum = CashInOut::where('payment_method_id', $paymentMethod->id)
                ->where('type', 1) // CashIn transactions
                ->sum('amount');

            $cashOutSum = CashInOut::where('payment_method_id', $paymentMethod->id)
                ->where('type', 2) // CashOut transactions
                ->sum('amount');
            $saleReturnSum = SaleReturn::where('payment_method_id', $paymentMethod->id)
                ->sum('returnAmount');
            $cost = Cost::where('payment_method_id', $paymentMethod->id)
                ->sum('amount');

            $purchaseReturnSum = PurchaseReturn::where('payment_method_id', $paymentMethod->id)
                ->sum('returnAmount');
            $PaySalarySum = EmployeeSalary::where('payment_method_id', $paymentMethod->id)
                ->sum('paid');
            $totalAmount = ($paymentMethod->sale_payments_sum_paid + $purchaseReturnSum) - ($saleReturnSum + $paymentMethod->purchase_payments_sum_paid + $cost + $PaySalarySum);
            $netCashInOutAmount = $cashInSum - $cashOutSum;
            $totalAmount += $netCashInOutAmount;

            $payment_method[] = [
                'current_balance' => $totalAmount,
                'name' => $paymentMethod->name,
                'id' => $paymentMethod->id,
            ];
        }

        return $payment_method;
    }
}
