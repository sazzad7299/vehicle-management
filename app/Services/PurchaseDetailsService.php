<?php

namespace App\Services;

use App\Models\PurchaseDetails;

class PurchaseDetailsService
{
    public function store($request, $purchaseDetails)
    {

        $purchaseDetails = PurchaseDetails::create($request);
    }
}
