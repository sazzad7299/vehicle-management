<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class CountryWiseDivisionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($country)
    {
        $divisions = Division::query()
            ->where('country_id', $country)
            ->select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return $this->respondSuccess($divisions, 'Division fetch successfully');
    }
}
