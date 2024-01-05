<?php

namespace App\Services;

use App\Models\Unit;

class UnitService
{
    public function index($request)
    {

        $unit = Unit::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $unit->get(['id', 'name']);
        } else {
            return $unit->paginate(request()->get('per_page', 10));
        }

    }

    public function store($request, $leaf)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $leaf->fill($requestedData)->save();

        return $leaf;
    }

    public function update($request, $leaf)
    {
        $requestedData = $request->all();
        if ($requestedData['status'] === true) {
            $requestedData['status'] = 1;
        }
        $leaf->fill($requestedData)->save();

        return $leaf;
    }

    public function delete($unit)
    {

        $unit->delete();
    }
}
