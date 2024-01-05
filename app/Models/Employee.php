<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Employee extends BaseModel
{
    use CreatedUpdatedBy,HasFactory,SoftDeletes;

    protected $table = 'employees';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'name',
        'email',
        'phone',
        'status',
        'country_id',
        'division_id',
        'district_id',
        'upazilas_id',
        'union_id',
        'joining_date',
        'leave_date',
        'place',
        'salary',
        'nid',
        'zip_code',
        'street_address',
        'image',
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
}
