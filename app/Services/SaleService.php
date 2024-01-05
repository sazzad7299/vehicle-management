<?php

namespace App\Services;

use App\Models\PurchaseDetails;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SalePayment;
use App\Models\SaleReturn;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;

class SaleService
{
    public function index($request)
    {
        $sale = Sale::query()->with('customer:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->when($request->customer, function ($query) use ($request) {
                return $query->where('customer_id', $request->customer);
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
            return $sale->get();
        } else {
            return $sale->paginate(request()->get('per_page', 10));
        }
    }

    public function view($id)
    {
        $sale = Sale::with('saleDetails:id,pharmacy_id,sale_id,medicine_id,quantity,expire_date,mrp,subtotal,discount,total', 'saleExchange:id,pharmacy_id,sale_id,medicine_id,quantity,expire_date,mrp,subtotal,discount,total', 'saleDetails.medicine:id,barcode,name', 'saleExchange.medicine:id,barcode,name', 'salePayment.paymentMethod:id,name', 'salePayment:id,pharmacy_id,sale_id,payment_method_id,paid,discount', 'customer:id,name,email,phone,address', 'saleReturn:id,sale_id,payment_method_id,quantity,price,returnAmount,discount,detail_id,medicine_id', 'saleReturn.paymentMethod:id,name', 'saleReturn.medicine:id,name,barcode')
            ->findOrFail($id);
        $sale->total_paid = $sale->salePayment->sum('paid');
        $sale->returnable_price = $sale->saleReturn->sum('price');
        $sale->return_price = $sale->saleReturn->sum('returnAmount');
        foreach ($sale->saleDetails as $saleDetail) {
            $relatedSaleReturn = $sale->saleReturn->where('detail_id', $saleDetail->id)->sum('quantity');
            if ($relatedSaleReturn) {
                $saleDetail->current_quantity = $saleDetail->quantity - $relatedSaleReturn;
            } else {
                $saleDetail->current_quantity = $saleDetail->quantity;
            }
        }
        foreach ($sale->saleExchange as $saleExchang) {
            $relatedSaleReturn = $sale->saleReturn->where('detail_id', $saleExchang->id)->sum('quantity');
            if ($relatedSaleReturn) {
                $saleExchang->current_quantity = $saleExchang->quantity - $relatedSaleReturn;
            } else {
                $saleExchang->current_quantity = $saleExchang->quantity;
            }
        }
        $sale->makeHidden(['created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at']);

        return $sale;
    }

    public function store($request, $sale)
    {
        $invoiceNumber = $this->generateInvoiceNumber(auth('sanctum')->user()->pharmacy_id);
        $request['invoice'] = $invoiceNumber;
        if ($request['invoice_discount_type'] === 'percent') {
            $request['invoice_discount_type'] = 1;
        } else {
            $request['invoice_discount_type'] = 2;
        }
        $request = Arr::except($request, ['payment_method_id']);

        return Sale::create($request);
    }

    private function generateInvoiceNumber($pharmacyId)
    {
        $lastInvoice = Sale::where('pharmacy_id', $pharmacyId)
            ->orderByDesc('created_at')
            ->first();

        $serialNumber = $lastInvoice ? (int) substr($lastInvoice->invoice, -7) + 1 : 1;

        $invoiceNumber = 'AMG-'.sprintf('%07d', $serialNumber);

        return $invoiceNumber;
    }

    public function saledetails($product, $id)
    {
        $saleDetails = [];
        foreach ($product as $key => $value) {
            if ($value == 0) {
                continue;
            }
            $sold_stock = $value['quantity'];
            $purchases = PurchaseDetails::where('medicine_id', $value['medicine_id'])->where('expire_date', $value['expire_date'])
                ->orderBy('id', 'asc')
                ->whereRaw('(quantity + s_return) - (sale + p_return) >= 0')
                ->get();
            $purchase_item = [];
            foreach ($purchases as $purchase) {
                // dd($sold_stock);
                $availableStock = ($purchase->quantity + $purchase->s_return) - ($purchase->sale + $purchase->p_return);
                if ($availableStock >= $sold_stock) {
                    $purchase->sale += $sold_stock;
                    $purchase_item[] = [
                        'id' => $purchase->id,
                        'sold_quantity' => $sold_stock,
                        'pp' => $purchase->pp,
                    ];
                    $sold_stock = 0;
                } else {
                    $purchase->sale += $availableStock;
                    $sold_stock -= $availableStock;
                    $purchase_item[] = [
                        'id' => $purchase->id,
                        'sold_quantity' => $availableStock,
                        'pp' => $purchase->pp,
                    ];
                }
                $purchase->save();
                if ($sold_stock == 0) {
                    break;
                }
            }
            $value['purchase_details'] = json_encode($purchase_item);
            $value['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            $value['sale_id'] = $id;
            \Log::info($value);
            $saleDetails[] = $value;
        }

        SaleDetails::insert($saleDetails);
    }

    public function SalePayment($request)
    {
        $salePayment = new SalePayment();
        $salePayment->pharmacy_id = auth('sanctum')->user()->pharmacy_id;
        $salePayment->sale_id = $request['sale_id'];
        $salePayment->payment_method_id = $request['payment_method_id'];
        $salePayment->paid = $request['paid'];
        $salePayment->discount = $request['discount'];
        $salePayment->save();
    }

    public function getPayment($request)
    {

        $salePaymentsQuery = SalePayment::query()
            ->with('paymentMethod:id,name') // Eager load the payment method relationship
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->when($request->customer, function ($query) use ($request) {
                return $query->whereHas('sale', function ($subQuery) use ($request) {
                    $subQuery->where('customer_id', $request->customer);
                });
            })
            ->select('sale_payments.*', 'customers.name as customer_name')
            ->join('sales', 'sale_payments.sale_id', '=', 'sales.id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('sale_payments.created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('sale_payments.created_at', '<=', $toDate);
            })
            ->latest();

        if ($request->has('paginate')) {
            return $salePaymentsQuery->get();
        } else {
            return $salePaymentsQuery->paginate(request()->get('per_page', 10));
        }
    }

    public function returnsale($request)
    {
        $sale_detail = SaleDetails::findOrFail($request['detail_id']);
        if (auth()->user()->pharmacy_id != $sale_detail->pharmacy_id) {
            throw new Exception('Access Denied');
        }
        $returned_qty = SaleReturn::where('detail_id', $sale_detail->id)->sum('quantity');
        //max return quanity
        $max = $sale_detail->quantity - $returned_qty;
        $return_qty = $request['quantity'];
        if ($return_qty > $sale_detail->quantity || $return_qty > $max) {
            $error_msg = 'You can not reture more then ('.$max.') Quantity';
            throw new Exception($error_msg);
        }
        $sale_purchase = json_decode($sale_detail->purchase_details, true);
        // return $sale_purchase;
        $purchase_item = [];
        foreach ($sale_purchase as $purchase) {
            $purchase_details = PurchaseDetails::where('id', $purchase['id'])->first();
            if ($purchase['sold_quantity'] >= $return_qty) {
                $purchase_details->s_return += $return_qty;
                $purchase_item[] = [
                    'id' => $purchase_details->id,
                    'sold_quantity' => $return_qty,
                    'pp' => $purchase['pp'],
                ];
                $return_qty = 0;
            } else {
                $purchase_details->s_return += $purchase['sold_quantity'];
                $purchase_item[] = [
                    'id' => $purchase_details->id,
                    'sold_quantity' => $purchase['sold_quantity'],
                    'pp' => $purchase['pp'],
                ];
                $return_qty -= $purchase['sold_quantity'];
            }
            $purchase_details->save();
            if ($return_qty == 0) {
                break;
            }
        }

        $sale_return = new SaleReturn;
        $request['pharmacy_id'] = $sale_detail->pharmacy_id;
        $request['medicine_id'] = $sale_detail->medicine_id;
        $request['sale_id'] = $sale_detail->sale_id;
        $request['purchase_details'] = json_encode($purchase_item);
        $sale_return->fill($request)->save();

    }

    public function returnindex($request)
    {
        $saleReturn = SaleReturn::query()->with('medicine:id,name', 'paymentMethod:id,name', 'customer:id,name')
            ->when($request->customer, function ($query) use ($request) {
                return $query->where('customer_id', $request->customer);
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
            return $saleReturn->get();
        } else {
            return $saleReturn->paginate(request()->get('per_page', 10));
        }
    }

    public function CustomerDueCollect($request)
    {
        $data = $request->all();
        $sales = Sale::with('salePayment:id,pharmacy_id,sale_id,payment_method_id,paid,discount', 'saleReturn:id,sale_id,payment_method_id,quantity,price,returnAmount,discount,detail_id,medicine_id', 'saleReturn.paymentMethod:id,name', 'saleReturn.medicine:id,name,barcode')
            ->where('customer_id', $data['customer_id'])->get();
        $dueSale = [];
        $availablebalance = $data['paid'];
        foreach ($sales as $sale) {
            $sale->total_paid = $sale->salePayment->sum('paid');
            $sale->returnable_price = $sale->saleReturn->sum('price');
            $sale->return_price = $sale->saleReturn->sum('returnAmount');
            $sale->currentDue = $sale->total + $sale->return_price - $sale->total_paid - $sale->returnable_price;
            if ($sale->currentDue > 0 && $availablebalance >= $sale->currentDue) {
                $paymentData['sale_id'] = $sale->id;
                $paymentData['payment_method_id'] = $data['payment_method_id'];
                $paymentData['paid'] = $sale->currentDue;
                $paymentData['discount'] = 0;
                $this->SalePayment($paymentData);
                $availablebalance -= $sale->currentDue;
            } elseif ($sale->currentDue > 0 && $availablebalance < $sale->currentDue) {
                $paymentData['sale_id'] = $sale->id;
                $paymentData['payment_method_id'] = $data['payment_method_id'];
                $paymentData['paid'] = $availablebalance;
                $paymentData['discount'] = 0;
                $this->SalePayment($paymentData);
                $availablebalance = 0;
            }
            if ($availablebalance == 0) {
                break;
            }

        }

        return $dueSale;
    }
}
