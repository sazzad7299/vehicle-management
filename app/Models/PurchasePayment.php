<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'purchase_payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'purchase_id',
        'payment_method_id',
        'paid',
        'discount',

    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
