<?php

namespace App\Services;

use App\Models\Customer;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class CustomerService
{
    use ImageUpload;
    //get customer

    public function index($request)
    {
        $customer = Customer::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->withSum('sales', 'total')
            ->withSum('sale_payments', 'paid')
            ->withSum('sale_return', 'price')
            ->withSum('sale_return', 'returnAmount')
            ->latest();
        if ($request->has('paginate')) {
            return $customer->select('id', 'name', 'phone')->get();
        } elseif ($request->has('report')) {
            return $customer->get();
        } else {
            return $customer->paginate(request()->get('per_page', 10));
        }
    }

    //customer store
    public function store($request, $customer)
    {
        $requestedData = $request->all();
        if ($request->has('image')) {
            $images = $request->image;
            if ($images) {
                $requestedData['image'] = $this->base64FileStore($images, 'images/customers/', rand(10000, 99999));
            }
        }
        if ($request->has('status')) {
            if ($requestedData['status'] == false) {
                $requestedData['status'] = 0;
            }
        }

        $customer->fill($requestedData)->save();

        return $customer;
    }

    public function update($request, $customer)
    {
        $requestedData = $request->all();
        $images = $request->image;
        if ($images) {
            if (file_exists($customer->image)) {
                unlink($customer->image);
            }
            $requestedData['image'] = $this->base64FileStore($images, 'images/customers/', rand(10000, 99999));
        } else {
            $requestedData = Arr::except($requestedData, ['image']);
        }
        if ($requestedData['status'] == false) {
            $requestedData['status'] = 0;
        }
        $customer->fill($requestedData)->save();
    }

    public function show($customer)
    {
        $customer->loadSum('sales', 'total');
        $customer->loadSum('sale_payments', 'paid');
        $customer->loadSum('sale_return', 'price');
        $customer->loadSum('sale_return', 'returnAmount');

        return $customer;

    }
}
