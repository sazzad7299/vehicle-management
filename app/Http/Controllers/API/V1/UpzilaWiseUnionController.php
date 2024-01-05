<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Union;
use Illuminate\Http\Request;

class UpzilaWiseUnionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($upzila)
    {
        $unions = Union::query()
            ->where('upazila_id', $upzila)
            ->select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return $this->respondSuccess($unions, 'Union fetch successfully');
    }
}
