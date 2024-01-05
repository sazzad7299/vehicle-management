<?php

namespace App\Services;

use App\Models\Supplier;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class SupplierService
{
    use ImageUpload;
    //get supplier

    public function index($request)
    {
        $supplier = Supplier::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->withSum('purchase', 'total')
            ->withSum('purchase_payment', 'paid')
            ->withSum('purchase_return', 'price')
            ->withSum('purchase_return', 'returnAmount')
            ->latest();

        if ($request->has('paginate')) {
            return $supplier->where('status', 1)->select('id', 'name', 'phone')->get();
        } elseif ($request->has('report')) {
            return $supplier->get();
        } else {
            return $supplier->paginate(request()->get('per_page', 10));
        }
    }

    //supplier store
    public function store($request, $supplier)
    {
        $requestedData = $request->all();
        $images = $request->image;
        if ($images) {
            $requestedData['image'] = $this->base64FileStore($images, 'images/suppliers/', rand(10000, 99999));
        }
        if ($requestedData['status'] == false) {
            $requestedData['status'] = 0;
        }
        $supplier->fill($requestedData)->save();

        return $supplier;
    }

    public function update($request, $supplier)
    {
        $requestedData = $request->all();
        $images = $request->image;
        if ($images) {
            if (file_exists($supplier->image)) {
                unlink($supplier->image);
            }
            $requestedData['image'] = $this->base64FileStore($images, 'images/suppliers/', rand(10000, 99999));
        } else {
            $requestedData = Arr::except($requestedData, ['image']);
        }
        if ($requestedData['status'] == false) {
            $requestedData['status'] = 0;
        }
        $supplier->fill($requestedData)->save();

        return $supplier;
    }

    public function show($supplier)
    {
        $supplier->loadSum('purchase', 'total');
        $supplier->loadSum('purchase_payment', 'paid');
        $supplier->loadSum('purchase_return', 'price');
        $supplier->loadSum('purchase_return', 'returnAmount');

        return $supplier;
    }
}
