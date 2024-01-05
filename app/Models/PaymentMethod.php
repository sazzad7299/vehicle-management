<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PaymentMethod extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'payment_methods';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'name',
        'description',
        'status',
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
        return $query->where('name', 'LIKE', '%'.$request.'%')
            ->orWhere('description', 'LIKE', '%'.$request.'%');
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class, 'payment_method_id');
    }

    public function salePayments()
    {
        return $this->hasMany(SalePayment::class, 'payment_method_id');
    }

    public function saleReturnPayments()
    {
        return $this->hasMany(SaleReturn::class, 'payment_method_id');
    }

    public function purchaseReturnPayments()
    {
        return $this->hasMany(PurchaseReturn::class, 'payment_method_id');
    }

    public function cashInOuts()
    {
        return $this->hasMany(CashInOut::class, 'payment_method_id');
    }
}
