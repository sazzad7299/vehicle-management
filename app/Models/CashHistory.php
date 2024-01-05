<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashHistory extends Model
{
    use CreatedUpdatedBy, HasFactory,  SoftDeletes;

    protected $table = 'cash_histories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pharmacy_id',
        'model_type',
        'model_id',
        'status',
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
