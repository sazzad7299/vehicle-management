<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetails extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id',
        'medicine_id',
        'pharmacy_id',
        'quantity',
        'expire_date',
        'mrp',
        'subtotal',
        'discount',
        'total',
        'is_exchange',
    ];

    // Define the relationships with other models

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
