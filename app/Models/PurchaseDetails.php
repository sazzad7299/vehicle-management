<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseDetails extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'pharmacy_id',
        'expire_date',
        'quantity',
        'pp',
        'mrp',
        'subtotal',
        'discount',
        'total',
        'purchase_id',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
