<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use CreatedUpdatedBy,HasFactory,SoftDeletes;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'status', 'access_by',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, RoleHasPermission::class, 'role_id', 'permission_id');
    }
}
