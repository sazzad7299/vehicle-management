<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Supplier extends BaseModel
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'name',
        'email',
        'phone',
        'company',
        'company_phone',
        'image',
        'address',
        'description',
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

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }

    public function purchase_payment()
    {
        return $this->hasManyThrough(PurchasePayment::class, Purchase::class);
    }

    public function purchase_return()
    {
        return $this->hasManyThrough(PurchaseReturn::class, Purchase::class);
    }
}
