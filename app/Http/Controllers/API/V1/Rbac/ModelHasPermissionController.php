<?php

namespace App\Http\Controllers\API\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModelHasPermissionRequest;
use App\Http\Requests\UpdateModelHasPermissionRequest;
use App\Models\ModelHasPermission;

class ModelHasPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModelHasPermissionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelHasPermission $modelHasPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelHasPermission $modelHasPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModelHasPermissionRequest $request, ModelHasPermission $modelHasPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelHasPermission $modelHasPermission)
    {
        //
    }
}
