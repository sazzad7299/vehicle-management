<?php

namespace App\Models;

use App\Scopes\PharmacyScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PharmacyScope);
    }
}
