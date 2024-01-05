<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'name',
        'phone',
        'email',
        'image',
        'address',
        'note',
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

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request.'%')
            ->orWhere('phone', 'LIKE', '%'.$request.'%')
            ->orWhere('email', 'LIKE', '%'.$request.'%');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    public function sale_payments()
    {
        return $this->hasManyThrough(SalePayment::class, Sale::class);
    }

    public function sale_return()
    {
        return $this->hasManyThrough(SaleReturn::class, Sale::class);
    }
}
