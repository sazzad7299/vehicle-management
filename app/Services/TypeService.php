<?php

namespace App\Services;

use App\Models\Type;

class TypeService
{
    public function index($request)
    {

        $leaf = Type::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $leaf->get();
        } else {
            return $leaf->paginate(request()->get('per_page', 10));
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

    public function delete($id)
    {

        $leaf = Type::findOrFail($id);
        $leaf->delete();
    }
}
