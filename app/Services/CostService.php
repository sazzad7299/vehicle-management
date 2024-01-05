<?php

namespace App\Services;

use App\Models\Cost;

class CostService
{
    public function index($request)
    {
        $payment_method = Cost::query()->with('paymentMethod:id,name')
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
            return $payment_method->get();
        } else {
            return $payment_method->paginate(request()->get('per_page', 10));
        }
    }

    public function store($request, $cost)
    {
        $requestedData = $request->all();
        $requestedData['pharmacy_id'] = auth()->user()->pharmacy_id;
        $data = $cost->fill($requestedData)->save();

        return $data;
    }

    public function update($request, $cost)
    {
        $requestedData = $request->all();
        $cost = $cost->fill($requestedData)->save();

        return $cost;
    }

    public function delete($balance_info)
    {
        $balance_info->delete();
    }
}
