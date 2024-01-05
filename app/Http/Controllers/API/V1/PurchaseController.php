<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\StorePurchaseReturnRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Services\PurchaseDetailsService;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $purchase;

    protected $purchaseDetails;

    public function __construct(PurchaseService $purchase, PurchaseDetailsService $purchaseDetails)
    {
        $this->purchaseDetails = $purchaseDetails;
        $this->purchase = $purchase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchase = $this->purchase->index($request);

        return $this->respondSuccess(['purchase' => $purchase, 'filter' => $request->all()], 'Purchase Retrieved Successfully');
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
    public function store(StorePurchaseRequest $request, Purchase $purchase, PurchaseDetails $purchaseDetails)
    {
        DB::beginTransaction();

        try {
            $requestedData = $request->all();
            $purchaseData = $requestedData['purchase'];
            $purchaseData['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            $purchaseProductsData = $requestedData['purchaseProducts'];

            $purchase = $this->purchase->store($purchaseData, $purchase);
            //purchaseDetaisl Store Purchase Medicines
            $purchaseDetails = [];
            foreach ($requestedData['purchaseProducts'] as $productData) {
                $productData['purchase_id'] = $purchase->id;
                $productData['medicine_id'] = $productData['id'];
                $productData['pharmacy_id'] = $purchase->pharmacy_id;
                $productData = Arr::except($productData, ['id', 'barcode', 'name']);
                $purchaseDetails[] = $productData;
            }

            PurchaseDetails::insert($purchaseDetails);

            //Purchase Payment Store
            if ($purchase->paid > 0) {
                $paymentinfo['purchase_id'] = $purchase->id;
                $paymentinfo['payment_method_id'] = $purchase->payment_method_id;
                $paymentinfo['paid'] = $purchase->paid;
                $paymentinfo['discount'] = 0;
                // return $paymentinfo;
                $this->purchase->purchasePayment($paymentinfo);
            }

            DB::commit();

            return $this->respondCreated($purchase, 'Purchase Inserted Successfully!');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->respondError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $purchase = $this->purchase->view($purchase);
        $purchase = $this->purchase->show($id);

        return $this->respondCreated($purchase, 'Purchase Details Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function returnPurchase(StorePurchaseReturnRequest $request)
    {
        $requestedData = $request->all();
        try {
            $return = $this->purchase->return($requestedData);

            return $this->respondSuccess($return, 'Purchase Return Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function returnPurchaseList(Request $request)
    {
        try {
            $purchase_return = $this->purchase->returnindex($request);

            return $this->respondSuccess(['return' => $purchase_return, 'filter' => $request->all()], 'Purchase Return Retrieved Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }

    public function supplierDuePayment(Request $request)
    {
        $data = $request->all();
        $sale = $this->purchase->SupplierDuePayment($request);

        return $this->respondSuccess($sale, 'Due collect successfully!');
    }
}
