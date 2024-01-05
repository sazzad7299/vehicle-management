<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePayment extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'sale_payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'sale_id',
        'payment_method_id',
        'paid',
        'discount',

    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
