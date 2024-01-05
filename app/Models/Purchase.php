<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Purchase extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'purchases';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'invoice',
        'subtotal',
        'medicine_discount',
        'total',
        'invoice_discount_amount',
        'paid',
        'due',
        'total_quantity',
        'payment_method_id',
        'supplier_id',
        'invoice_discount_type',
    ];

    public function scopePharmacy($query)
    {
        $query->where('pharmacy_id', Auth::user()->pharmacy_id);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('invoice', 'LIKE', '%'.$request.'%');
    }

    //relation
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);

    }

    public function purchasePayment()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}
