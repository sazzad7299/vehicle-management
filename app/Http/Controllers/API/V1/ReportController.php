<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportService $report)
    {
        $this->report = $report;
    }

    public function summary(Request $request)
    {
        $summary = $this->report->summary($request);

        return $this->respondSuccess($summary, 'Account Summary Retrieved Successfully');

    }

    public function expired(Request $request)
    {
        $expired = $this->report->expired($request);

        return $this->respondSuccess($expired, 'Expired medicine Retrieved Successfully');
    }

    public function stocks(Request $request)
    {
        $stock = $this->report->stocks($request);

        return $this->respondSuccess(['stock' => $stock, 'filter' => $request->all()], 'Medicine Stock Retrieved Successfully');
    }

    public function profit(Request $request)
    {
        $profit = $this->report->profit($request);

        return $this->respondSuccess(['profit' => $profit, 'filter' => $request->all()], 'Profit Retrieved Successfully');
    }

    public function yearly(Request $request)
    {
        $yearly = $this->report->yearly();

        return $this->respondSuccess($yearly, 'Profit Retrieved Successfully');
    }
}
