<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Medicine extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'medicines';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'barcode',
        'name',
        'generic',
        'manufacturer_id',
        'leaf_id',
        'unit_id',
        'category_id',
        'type_id',
        'image',
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
        return $query->where('barcode', 'LIKE', '%'.$request.'%')
            ->orWhere('name', 'LIKE', '%'.$request.'%');
    }

    //relation data
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class);
    }
}
