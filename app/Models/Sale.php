<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Sale extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'customer_id',
        'invoice',
        'subtotal',
        'medicine_discount',
        'total',
        'invoice_discount_amount',
        'paid',
        'due',
        'total_quantity',
        'payment_method_id',
        'invoice_discount_type',
    ];

    // Sale.php (Sale model)
    public function scopePharmacy($query)
    {
        $query->where('pharmacy_id', Auth::user()->pharmacy_id);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id')->where('is_exchange', null);
    }

    public function saleExchange()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id')
            ->where('is_exchange', 1); // Assuming is_exchange is the column name
    }

    public function salePayment()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function saleReturn()
    {
        return $this->hasMany(SaleReturn::class, 'sale_id');
    }
    // Sale.php (Sale model)

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('invoice', 'LIKE', '%'.$request.'%');
    }
}
