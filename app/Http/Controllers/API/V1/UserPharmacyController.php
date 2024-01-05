<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class UserPharmacyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $pharmacyId = auth('sanctum')->user()->pharmacy_id;
        $pharmacy = Pharmacy::query()
            // ->where('id', $pharmacyId)
            ->get(['id', 'company_name']);

        return $this->respondSuccess($pharmacy, 'Pharmacy Retrieved Successfully');
    }
}
