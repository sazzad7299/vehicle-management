<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use CreatedUpdatedBy,HasApiTokens, HasFactory,  Notifiable;

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = new LogOptions();

        $logOptions->logName = 'user_log';
        $logOptions->logOnly(['name', 'email']);
        // Add other options as needed

        return $logOptions;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pharmacy_id',
        'name',
        'email',
        'phone',
        'password',
        'user_status',
        'country_id',
        'division_id',
        'district_id',
        'upazilas_id',
        'union_id',
        'zip_code',
        'street_address',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, ModelHasRole::class, 'model_id', 'role_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id')->withDefault();
    }

    public function hasPermission($permissionName)
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->name === $permissionName) {
                    return true;
                }
            }
        }

        return false;
    }

    public function user_membership()
    {
        return $this->hasMany(Subscription::class, 'pharmacy_id', 'pharmacy_id');
    }

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request.'%');
    }
}
