<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DivisionWiseDistrictController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($division)
    {
        $districts = District::query()
            ->where('division_id', $division)
            ->select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return $this->respondSuccess($districts, 'District fetch successfully');
    }
}
