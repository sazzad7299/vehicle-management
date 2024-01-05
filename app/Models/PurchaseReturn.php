<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturn extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'purchase_returns';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id', 'purchase_id', 'detail_id', 'medicine_id', 'returnAmount', 'price', 'quantity', 'payment_method_id',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
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
