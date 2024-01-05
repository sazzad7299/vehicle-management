<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'sale_returns';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id', 'sale_id', 'purchase_details', 'detail_id', 'medicine_id', 'returnAmount', 'price', 'quantity', 'payment_method_id', 'customer_id',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
