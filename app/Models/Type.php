<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Type extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'name',
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
            ->orWhere('description', 'LIKE', '%'.$request.'%');
    }
}
