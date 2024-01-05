<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class GetCountryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $countries = Country::query()
            ->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->get();

        return $this->respondSuccess($countries, 'Countries fetched successfully.');
    }
}
