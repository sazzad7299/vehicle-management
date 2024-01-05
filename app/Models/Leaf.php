<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Leaf extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'leaves';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'leaf_type',
        'number_per_box',
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
        return $query->where('leaf_type', 'LIKE', '%'.$request.'%')
            ->orWhere('description', 'LIKE', '%'.$request.'%');
    }
}
