<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use CreatedUpdatedBy, HasFactory,SoftDeletes;

    protected $table = 'plans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'monthly',
        'annually',
        'image',
        'description',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request->search.'%');
    }

    public function features()
    {
        return $this->hasMany(PlanFeatuers::class, 'plan_id');
    }
}
