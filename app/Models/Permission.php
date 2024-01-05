<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'display_name',
        'module',
        'description',
        'type',
    ];

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request->search.'%');
    }
}
