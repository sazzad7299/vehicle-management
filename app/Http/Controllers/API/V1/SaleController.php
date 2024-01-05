<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalePaymentRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\StoreSaleReturnRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    protected $sale;

    public function __construct(SaleService $sale)
    {

        $this->sale = $sale;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sale = $this->sale->index($request);

        return $this->respondSuccess(['sale' => $sale, 'filter' => $request->all()], 'Purchase Retrieved Successfully');
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
    public function store(StoreSaleRequest $request, Sale $sale)
    {
        // return $request->all();
        DB::beginTransaction();

        try {
            $requestedData = $request->all();
            $saleData = $requestedData['sale'];
            $saleData['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            $saleProductsData = $requestedData['saleProducts'];

            // return $saleProductsData;
            $sale = $this->sale->store($saleData, $sale);

            $this->sale->saledetails($saleProductsData, $sale->id);
            if ($saleData['paid'] > 0) {
                $salePaymentData['payment_method_id'] = $saleData['payment_method_id'];
                $salePaymentData['paid'] = $saleData['paid'];
                $salePaymentData['sale_id'] = $sale->id;
                $salePaymentData['discount'] = 0;
                $this->sale->SalePayment($salePaymentData);
            }
            $sale = $this->sale->view($sale->id);
            DB::commit();

            return $this->respondCreated($sale, 'Sale Created Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->respondError('Sale Insert Failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = $this->sale->view($id);

        return $this->respondSuccess($sale, 'Sale Inserted Successfully!');
    }

    public function saleByInvoice($invoice)
    {
        $getsale = Sale::where('invoice', $invoice)->first();
        if ($getsale) {
            $sale = $this->sale->view($getsale->id);

            return $this->respondSuccess($sale, 'Get the sale Successfully!');
        } else {
            return $this->respondError('Get the sale Successfully!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    public function salePayment(StoreSalePaymentRequest $request)
    {

        $salePaymentData = $request->all();
        $payment = $this->sale->SalePayment($salePaymentData);

        return $this->respondSuccess($payment, 'Payment Taken Successfully!');
    }

    public function getPayment(Request $request)
    {

        $payment = $this->sale->getPayment($request);

        return $this->respondSuccess([
            'payment' => $payment, 'filter' => $request->all(),
        ], 'Payment Retrieved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function returnSale(StoreSaleReturnRequest $request)
    {
        $requestedData = $request->all();
        try {
            $return = $this->sale->returnsale($requestedData);

            return $this->respondSuccess($return, 'Return Sale Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function returnSaleList(Request $request)
    {
        try {
            $returnsale = $this->sale->returnindex($request);

            return $this->respondSuccess(['return' => $returnsale, 'filter' => $request->all()], 'Sale Return Retrieved Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }

    public function customerDuePayment(Request $request)
    {
        $sale = $this->sale->CustomerDueCollect($request);

        return $this->respondSuccess($sale, 'Due collect successfully!');
    }

    public function saleExchange(Request $request)
    {
        DB::beginTransaction();
        try {
            $requestedData = $request->all();
            $saleData = $requestedData['sale'];
            $returnData = $requestedData['exchange'];
            $saleProductsData = $requestedData['saleProducts'];
            $sale = Sale::findOrfail($saleData['sale_id']);
            $sale->update(['total' => $sale->total + $saleData['total'], 'subtotal' => $sale->subtotal + $saleData['total']]);
            $this->sale->saledetails($saleProductsData, $saleData['sale_id']);
            foreach ($returnData as $data) {
                $this->sale->returnsale($data);
            }
            if ($saleData['paid'] > 0) {
                $salePaymentData['payment_method_id'] = $saleData['payment_method_id'];
                $salePaymentData['paid'] = $saleData['paid'];
                $salePaymentData['sale_id'] = $sale->id;
                $salePaymentData['discount'] = 0;
                $this->sale->SalePayment($salePaymentData);
            }
            DB::commit();

            return $this->respondSuccess(null, 'Product Exchange Successfully');

        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }
}
