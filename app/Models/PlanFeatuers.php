<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanFeatuers extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'plan_id', 'model', 'quote'];
}
