<?php

namespace App\Services;

use App\Models\Manufacturer;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class ManufacturerService
{
    use ImageUpload;

    public function index($request)
    {
        $manufacturer = Manufacturer::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $manufacturer->select(['id', 'name'])->get();
        } else {
            return $manufacturer->paginate(request()->get('per_page', 10));
        }
    }

    public function store($request, $manufacturer)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $images = $request->logo;
        if ($images) {
            $requestedData['logo'] = $this->base64FileStore($images, 'images/manufacturer/', rand(10000, 99999));
        }
        $manufacturer->fill($requestedData)->save();

        return $manufacturer;
    }

    public function update($request, $manufacturer)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $images = $request->logo;
        if ($images) {
            if (file_exists($manufacturer->logo)) {
                unlink($manufacturer->logo);
            }
            $requestedData['logo'] = $this->base64FileStore($images, 'images/manufacturer/', rand(10000, 99999));
        } else {
            $requestedData = Arr::except($requestedData, ['logo']);
        }
        $manufacturer->fill($requestedData)->save();

        return $manufacturer;
    }

    public function delete($manufacturer)
    {
        if (file_exists($manufacturer->logo)) {
            unlink($manufacturer->logo);
        }
        $manufacturer->delete();
    }
}
