<?php

namespace App\Services;

use App\Models\Medicine;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class MedicineService
{
    use ImageUpload;

    public function index($request)
    {
        $medicine = Medicine::query()->with('category:id,name', 'manufacturer:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $medicine->select(['id', 'name'])->get();
        } elseif ($request->has('report')) {
            return $medicine->get();
        } else {
            return $medicine->paginate(request()->get('per_page', 10));
        }
    }

    public function store($request, $medicine)
    {
        $requestedData = $request->all();
        $images = $request->image;
        if ($images) {
            $requestedData['image'] = $this->base64FileStore($images, 'images/medicine/', rand(10000, 99999));
        }
        if ($requestedData['status'] == false) {
            $requestedData['status'] = 0;
        } else {
            $requestedData['status'] = 1;
        }
        $medicine->fill($requestedData)->save();

        return $medicine;
    }

    public function update($request, $medicine)
    {
        $requestedData = $request->all();
        $images = $request->image;

        if ($images) {
            if (file_exists($medicine->image)) {
                unlink($medicine->image);
            }
            $requestedData['image'] = $this->base64FileStore($images, 'images/medicine/', rand(10000, 99999));
        }

        if (isset($requestedData['status']) && $requestedData['status'] == false) {
            $requestedData['status'] = 0;
        } else {
            $requestedData = Arr::except($requestedData, ['image']);
        }

        $medicine->update($requestedData);

        return $medicine;
    }

    public function delete($medicine)
    {
        if (file_exists($medicine->image)) {
            unlink($medicine->image);
        }
        $medicine->delete();
    }
}
