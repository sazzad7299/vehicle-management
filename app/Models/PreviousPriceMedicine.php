<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousPriceMedicine extends Model
{
    use CreatedUpdatedBy, HasFactory;

    protected $table = 'previous_price_medicines';

    protected $primaryKey = 'id';

    protected $fillable = [
        'medicine_id',
        'buy_price',
        'sell_price',
        'vat',
        'status',
    ];
}
