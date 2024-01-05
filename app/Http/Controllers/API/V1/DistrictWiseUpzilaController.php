<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Upzila;
use Illuminate\Http\Request;

class DistrictWiseUpzilaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($district)
    {
        $upzila = Upzila::query()
            ->where('district_id', $district)
            ->select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return $this->respondSuccess($upzila, 'Upzila fetch successfully');
    }
}
