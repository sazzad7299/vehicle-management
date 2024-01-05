<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'pharmacies';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'company_name',
        'mobile_no',
        'website',
        'country',
        'division_id',
        'district_id',
        'upazilas_id',
        'union_id',
        'zip_code',
        'street_address',
        'google_map_location',
        'reffer_by_name',
        'reffer_by_phone',
        'note',
        'logo',
        'expire_date',
        'plan_id',
        'status',
    ];

    public function scopeActive($query): void
    {
        $query->where('status', 1);
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('company_name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
