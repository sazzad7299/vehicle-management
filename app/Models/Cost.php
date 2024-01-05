<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'costs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'cost_category_id',
        'payment_method_id',
        'date',
        'name',
        'amount',
        'cost_by',
        'image',
        'note',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request->search.'%');
    }
}
