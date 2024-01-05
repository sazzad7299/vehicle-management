<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousPricePlan extends Model
{
    use CreatedUpdatedBy, HasFactory;

    protected $table = 'previous_price_plans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'plan_id',
        'price',
        'offer_type',
        'offer',
        'total_price',
        'duration_type',
        'duration',
        'status',
    ];
}
