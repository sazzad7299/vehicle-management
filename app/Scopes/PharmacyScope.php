<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PharmacyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = auth()->user();
        if ($user && $user->pharmacy_id !== null) {
            $builder->where($model->getTable().'.pharmacy_id', auth()->user()->pharmacy_id);
        }
    }
}
