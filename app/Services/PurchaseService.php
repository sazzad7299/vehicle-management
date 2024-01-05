<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;
use Carbon\Carbon;
use Exception;

class PurchaseService
{
    public function index($request)
    {
        $purchase = Purchase::query()->with('supplier:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->when($request->supplier, function ($query) use ($request) {
                return $query->where('supplier_id', $request->supplier);
            })
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->latest();
        if ($request->has('paginate')) {
            return $purchase->get();
        } else {
            return $purchase->paginate(request()->get('per_page', 10));
        }
    }

    public function store($request, $purchase)
    {
        $invoiceNumber = $this->generateInvoiceNumber(auth('sanctum')->user()->pharmacy_id);
        $request['invoice'] = $invoiceNumber;
        if ($request['invoice_discount_type'] === 'percent') {
            $request['invoice_discount_type'] = 1;
        } else {
            $request['invoice_discount_type'] = 2;
        }
        $new = Purchase::create($request);

        return $new;
    }

    private function generateInvoiceNumber($pharmacyId)
    {
        $lastInvoice = Purchase::where('pharmacy_id', $pharmacyId)
            ->orderByDesc('created_at')
            ->first();

        $serialNumber = $lastInvoice ? (int) substr($lastInvoice->invoice, -7) + 1 : 1;

        $invoiceNumber = sprintf('%07d', $serialNumber);

        return $invoiceNumber;
    }

    public function purchasePayment($request)
    {
        $purchasePayment = new PurchasePayment();
        $purchasePayment->pharmacy_id = auth('sanctum')->user()->pharmacy_id;
        $purchasePayment->purchase_id = $request['purchase_id'];
        $purchasePayment->payment_method_id = $request['payment_method_id'];
        $purchasePayment->paid = $request['paid'];
        $purchasePayment->discount = $request['discount'];
        $purchasePayment->save();
    }

    public function return($request)
    {
        $purchaseData = PurchaseDetails::findOrFail($request['detail_id']);
        if (auth()->user()->pharmacy_id != $purchaseData->pharmacy_id) {
            throw new Exception('Access Denied');
        }
        $request['pharmacy_id'] = $purchaseData->pharmacy_id;
        $request['medicine_id'] = $purchaseData->medicine_id;
        $request['purchase_id'] = $purchaseData->purchase_id;
        // return $request;
        $purchaseData->p_return += $request['quantity'];
        $purchaseData->save();
        $purchase_return = new PurchaseReturn;
        $purchase_return->fill($request)->save();
    }

    public function returnindex($request)
    {
        $purchase_return = PurchaseReturn::query()->with('medicine:id,name', 'paymentMethod:id,name')
            ->latest()
            ->select('purchase_returns.*', 'suppliers.name as supplier_name')
            ->join('purchases', 'purchase_returns.purchase_id', '=', 'purchases.id')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('purchase_returns.created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('purchase_returns.created_at', '<=', $toDate);
            });

        if ($request->has('paginate')) {
            return $purchase_return->get();
        } else {
            return $purchase_return->paginate(request()->get('per_page', 10));
        }
    }

    public function show($id)
    {
        $purchase = Purchase::with('supplier:id,name,email,phone,address', 'purchaseDetails.medicine:id,name,barcode', 'purchasePayment.paymentMethod', 'purchaseReturns.medicine:id,name,barcode', 'purchaseReturns.paymentMethod:id,name')
            ->findOrFail($id);
        $purchase->total_paid = $purchase->purchasePayment->sum('paid');
        $purchase->returnable_price = $purchase->purchaseReturns->sum('price');
        $purchase->return_price = $purchase->purchaseReturns->sum('returnAmount');
        $purchase->makeHidden(['created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at']);
        foreach ($purchase->purchaseDetails as $detail) {
            $detail->makeHidden(['created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at']);
            $availableStock = ($detail->quantity + $detail->s_return) - ($detail->p_return + $detail->sale);
            $detail->available_stock = $availableStock;
        }

        return $purchase;
    }

    public function payments($request)
    {
        $salePaymentsQuery = PurchasePayment::query()
            ->with('paymentMethod:id,name') // Eager load the payment method relationship
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->when($request->supplier, function ($query) use ($request) {
                return $query->whereHas('purchase', function ($subQuery) use ($request) {
                    $subQuery->where('supplier_id', $request->supplier);
                });
            })
            ->latest()
            ->select('purchase_payments.*', 'suppliers.name as supplier_name')
            ->join('purchases', 'purchase_payments.purchase_id', '=', 'purchases.id')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('purchase_payments.created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('purchase_payments.created_at', '<=', $toDate);
            });

        if ($request->has('paginate')) {
            return $salePaymentsQuery->get();
        } else {
            return $salePaymentsQuery->paginate(request()->get('per_page', 10));
        }
    }

    public function SupplierDuePayment($request)
    {
        $data = $request->all();
        $purchases = Purchase::with('purchasePayment:id,pharmacy_id,purchase_id,payment_method_id,paid,discount', 'purchaseReturns:id,purchase_id,payment_method_id,quantity,price,returnAmount,detail_id,medicine_id')
            ->where('supplier_id', $data['supplier_id'])->get();
        // return $purchase;
        $dueSale = [];
        $availablebalance = $data['paid'];
        foreach ($purchases as $purchase) {
            $purchase->total_paid = $purchase->purchasePayment->sum('paid');
            $purchase->returnable_price = $purchase->purchaseReturns->sum('price');
            $purchase->return_price = $purchase->purchaseReturns->sum('returnAmount');
            $purchase->currentDue = $purchase->total + $purchase->return_price - $purchase->total_paid - $purchase->returnable_price;
            if ($purchase->currentDue > 0 && $availablebalance >= $purchase->currentDue) {
                $paymentData['purchase_id'] = $purchase->id;
                $paymentData['payment_method_id'] = $data['payment_method_id'];
                $paymentData['paid'] = $purchase->currentDue;
                $paymentData['discount'] = 0;
                $this->purchasePayment($paymentData);
                $availablebalance -= $purchase->currentDue;
            } elseif ($purchase->currentDue > 0 && $availablebalance < $purchase->currentDue) {
                $paymentData['purchase_id'] = $purchase->id;
                $paymentData['payment_method_id'] = $data['payment_method_id'];
                $paymentData['paid'] = $availablebalance;
                $paymentData['discount'] = 0;
                $this->purchasePayment($paymentData);
                $availablebalance = 0;
            }
            if ($availablebalance == 0) {
                break;
            }

        }

        return $dueSale;
    }
}
