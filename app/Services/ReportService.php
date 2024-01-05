<?php

namespace App\Services;

use App\Models\Cost;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\SaleReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportService
{
    public function summary($request)
    {
        $summary = [];
        $condition = $request->input('condition', 'all');

        // $sale = Sale::query();
        // if ($condition === 'today') {
        //     $sale->whereDate('created_at', Carbon::today());
        // } elseif ($condition === 'thisMonth') {
        //     $sale->whereYear('created_at', Carbon::now()->year)
        //         ->whereMonth('created_at', Carbon::now()->month);
        // }
        // $sale = $sale->sum('total');

        // $summary[] = [
        //     'name' => 'Sale',
        //     'amount' => $sale,
        // ];
        // $saleRerturn = SaleReturn::query()
        //     ->sum('price');
        // $summary[] = [
        //     'name' => 'Sale Return',
        //     'amount' => $saleRerturn,
        // ];

        // $SalePayment = SalePayment::query()
        //     ->sum('paid');

        // $summary[] = [
        //     'name' => 'Sale Payment',
        //     'amount' => $SalePayment,
        // ];
        // $SalereturnAmount = SaleReturn::query()
        //     ->sum('returnAmount');

        // $summary[] = [
        //     'name' => 'Sale Return Payment',
        //     'amount' => $SalereturnAmount,
        // ];

        // //Purchase
        // $purchase = Purchase::query()
        //     ->sum('total');
        // $summary[] = [
        //     'name' => 'Purchase',
        //     'amount' => $purchase,
        // ];
        // $PurchaseReturn = PurchaseReturn::query()
        //     ->sum('price');
        // $summary[] = [
        //     'name' => 'Purchase Return',
        //     'amount' => $PurchaseReturn,
        // ];
        // $PurchasePayment = PurchasePayment::query()
        //     ->sum('paid');

        // $summary[] = [
        //     'name' => 'Purchase Payment',
        //     'amount' => $PurchasePayment,
        // ];

        // $PurchaseReturnAmount = PurchaseReturn::query()
        //     ->sum('returnAmount');
        // $summary[] = [
        //     'name' => 'Purchase Return Amount',
        //     'amount' => $PurchaseReturnAmount,
        // ];

        // $customer = Customer::query()
        //     ->count();
        // $summary[] = [
        //     'name' => 'Customer',
        //     'amount' => $customer,
        // ];
        $employee = Employee::query()
            ->count();
        $summary[] = [
            'name' => 'Employee',
            'amount' => $employee,
        ];
        $user = User::query();
        if (auth()->user()->pharmacy_id != null) {
            $user = $user->where('pharmacy_id', auth()->user()->pharmacy_id);
        }

        $user = $user->count();
        $summary[] = [
            'name' => 'Users',
            'amount' => $user,
        ];
        $medicine = Medicine::query();
        if (auth()->user()->pharmacy_id != null) {
            $user = $user->where('pharmacy_id', auth()->user()->pharmacy_id);
        }

        $medicine = $medicine->count();
        $summary[] = [
            'name' => 'Vehicles',
            'amount' => $medicine,
        ];
        $cost = Cost::query()
            ->sum('amount');
        $summary[] = [
            'name' => 'Cost',
            'amount' => $cost,
        ];

        return $summary;
    }

    public function expired($request)
    {
        $currentDate = Carbon::now();
        $expired = PurchaseDetails::query()
            ->with('medicine:id,name,barcode')
            ->select('medicine_id', 'quantity', 'expire_date', 'pp', 'purchase_id')
            ->whereDate('expire_date', '<', $currentDate)
            ->whereRaw('(quantity + s_return) - (sale + p_return) > 0')
            ->paginate(request()->get('per_page', 10));

        return $expired;
    }

    public function stocks($request)
    {
        $currentDate = Carbon::now();
        $stocks = PurchaseDetails::query()
            ->with('medicine:id,name,barcode,generic')
            ->select('medicine_id', 'expire_date', 'pp', 'purchase_id')
            ->selectRaw('SUM((quantity + s_return) - (sale + p_return)) as total_qty, SUM(((quantity + s_return) - (sale + p_return) )* pp) as stock_price')
            ->whereDate('expire_date', '>=', $currentDate)
            ->when($request->has('stock') && $request->input('stock') === 'in', function ($query) {
                return $query->havingRaw('total_qty > 0')
                    ->groupBy('expire_date', 'medicine_id');
            })
            ->when($request->has('stock') && $request->input('stock') === 'out', function ($query) {
                return $query->havingRaw('SUM(CASE WHEN (quantity + s_return) - (sale + p_return) > 0 THEN 1 ELSE 0 END) = 0')
                    ->groupBy('medicine_id');
            });
        if ($request->has('paginate')) {
            return $stocks->get();
        } else {
            return $stocks->paginate(request()->get('per_page', 10));
        }

        return $stocks;
    }

    public function profit($request)
    {
        $sales = Sale::query()
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->get();
        Log::info($sales);

        $totalProfit = 0;

        // Loop through each sale and calculate profit
        if ($sales) {
            $salePrice = 0;
            $salePayment = 0;
            foreach ($sales as $sale) {
                $saleDetails = $sale->saleDetails;
                $purchaseRate = 0;
                foreach ($saleDetails as $details) {
                    $purchaseDetails = json_decode($details->purchase_details, true);

                    $totalPurchaseRate = 0;
                    foreach ($purchaseDetails as $purchase) {
                        $rate = $purchase['pp'];
                        $soldQuantity = $purchase['sold_quantity'];
                        $totalPurchaseRate += $rate * $soldQuantity;
                    }
                    $purchaseRate += $totalPurchaseRate;
                }
                $salePayment += $sale->salePayment->sum('paid');
                $salePrice += $sale->total;
                $totalProfit += $sale->total - $purchaseRate;
            }
        }
        $cost = Cost::query()
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->sum('amount');
        $report = [
            'Revenue' => $salePrice,
            'Profit' => $totalProfit,
            'Paid' => $salePayment,
            'Due' => $salePrice - $salePayment,
            'Cost' => $cost,
        ];

        return $report;
    }

    public function yearly()
    {
        $currentYear = Carbon::now()->year;
        \Log::info($currentYear);
        // Initialize an array to store the sale totals
        $saleTotals = [];
        $purchaseTotals = [];
        $costTotals = [];

        // Loop through the last 12 months
        for ($i = 1; $i <= 12; $i++) {
            // Calculate the start and end dates for the current month
            // $startDate = Carbon::createFromDate($currentYear, Carbon::now()->month - $i, 1)->startOfMonth();
            // $endDate = Carbon::createFromDate($currentYear, Carbon::now()->month - $i, 1)->endOfMonth();
            $startDate = Carbon::createFromDate($currentYear, Carbon::now()->subMonths($i)->month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($currentYear, Carbon::now()->subMonths($i)->month, 1)->endOfMonth();
            // $startDate = Carbon::now()->subMonths($i)->startOfMonth();
            // $endDate = Carbon::now()->subMonths($i)->endOfMonth();

            \Log::info($startDate);
            // Calculate the total sale for the current month
            $totalSale = Sale::whereBetween('created_at', [$startDate, $endDate])->sum('total');
            $totalPurchase = Purchase::whereBetween('created_at', [$startDate, $endDate])->sum('total');
            $totalCost = Cost::whereBetween('created_at', [$startDate, $endDate])->sum('amount');

            // Add the total sale to the array
            $saleTotals[] = $totalSale;
            $purchaseTotals[] = $totalPurchase;
            $costTotals[] = $totalCost;
        }

        // Reverse the array to have the totals in chronological order
        $saleTotals = array_reverse($saleTotals);
        $purchaseTotals = array_reverse($purchaseTotals);
        $costTotals = array_reverse($costTotals);
        $data = [
            'sale' => $saleTotals,
            'purchase' => $purchaseTotals,
            'cost' => $costTotals,
        ];

        return $data;
    }
}
