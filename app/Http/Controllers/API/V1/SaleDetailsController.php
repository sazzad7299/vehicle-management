<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSaleDetailsRequest;
use App\Models\SaleDetails;

class SaleDetailsController extends Controller
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
    public function store($data)
    {
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleDetails $saleDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleDetails $saleDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleDetailsRequest $request, SaleDetails $saleDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleDetails $saleDetails)
    {
        //
    }
}
