<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends BaseModel
{
    use CreatedUpdatedBy, HasFactory;

    protected $table = 'subscriptions';

    protected $dates = ['expired_at'];

    protected $fillable = [
        'pharmacy_id', 'plan_id', 'started_at', 'expired_at',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
