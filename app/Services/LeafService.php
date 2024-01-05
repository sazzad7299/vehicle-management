<?php

namespace App\Services;

use App\Models\Leaf;

class LeafService
{
    public function index($request)
    {

        $leaf = Leaf::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest();
        if ($request->has('paginate')) {
            return $leaf->select(['id', 'leaf_type'])->get();
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

        $leaf = Leaf::findOrFail($id);
        $leaf->delete();
    }
}
