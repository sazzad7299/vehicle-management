<?php

namespace App\Services;

use App\Models\CashInOut;

class CashInOutService
{
    public function index($request)
    {
        $payment_method = CashInOut::query()->with('paymentMethod:id,name')
        // ->when(request()->get('search'), function ($query) {
        //     return $query->search(request()->get('search'));
        // })
            ->latest();
        if ($request->type && $request->type != null) {
            $payment_method->where('type', $request->type);
        }
        if ($request->method && $request->method != null) {
            $payment_method->where('payment_method_id', $request->method);
        }
        if ($request->has('paginate')) {
            return $payment_method->select(['id'])->get();
        } else {
            return $payment_method->paginate(request()->get('per_page', 10));
        }
    }

    public function store($request, $cashInOut)
    {
        $requestedData = $request->all();
        $cash = $cashInOut->create($requestedData);

        return $cash;
    }

    public function update($request, $cashInOut)
    {
        $cash = $cashInOut->fill($request)->save();

        return $cash;
    }

    public function delete($balance_info)
    {
        $balance_info->delete();
    }
}
