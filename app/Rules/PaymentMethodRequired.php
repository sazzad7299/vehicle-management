<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PaymentMethodRequired implements Rule
{
    public function passes($attribute, $value)
    {
        $returnAmount = request('returnAmount') || request('paid') || request('purchase.paid');

        return ! ($returnAmount > 0 && empty($value));

    }

    public function message()
    {
        return 'Select Payment Method first';
    }
}
