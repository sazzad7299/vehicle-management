<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::paginate(10); // Adjust the number of items per page as needed
        return Inertia::render('Vehicles', [
            'vehicles' => $vehicles->items(),
            'pagination' => [
                'total' => $vehicles->total(),
                'perPage' => $vehicles->perPage(),
                'currentPage' => $vehicles->currentPage(),
                'totalPages' => $vehicles->lastPage(),
                'prevPageUrl' => $vehicles->previousPageUrl(),
                'nextPageUrl' => $vehicles->nextPageUrl(),
            ],
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
