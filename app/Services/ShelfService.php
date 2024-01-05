<?php

namespace App\Services;

use App\Models\ShelfNumber;

class ShelfService
{
    public function index($request)
    {
        $shelf = ShelfNumber::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest()
            ->paginate(request()->get('per_page', 10));

        return $shelf;
    }

    public function store($request, $shelf)
    {
        $requestedData = $request->all();

        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        if (! empty(auth('sanctum')->user()->pharmacy_id)) {
            $requestedData['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;

        }
        $shelf->fill($requestedData)->save();

        return $shelf;
    }

    public function update($request, $shelf)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $shelf->fill($requestedData)->save();

        return $shelf;
    }

    public function delete($id)
    {

        $shelf = ShelfNumber::findOrFail($id);
        $shelf->delete();
    }
}
