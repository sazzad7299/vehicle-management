<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashInOut extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'cash_in_outs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'type',
        'receipt_no',
        'payment_method_id',
        'date',
        'amount',
        'image',
        'source',
        'reference_by',
        'note',
        'status',
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('type', 'LIKE', '%'.$request.'%');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
