<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentMethodPharmacy extends Model
{
    use CreatedUpdatedBy, HasFactory;

    protected $table = 'payment_method_pharmacies';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'payment_method_id',
        'priority',
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
}
