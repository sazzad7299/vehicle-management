<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentMethodPharmacyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $selfId = $this->route('payment-method/pharmacy')->id; // assuming the route model binding is used
        $pharmacyId = $this->input('pharmacy_id');

        return [
            'pharmacy_id' => 'required',
            'payment_method_id' => [
                'required',
                'max:255',
                Rule::unique('payment_method_pharmacies')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'priority' => [
                'required',
                'max:255',
                Rule::unique('payment_method_pharmacies')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'status' => 'required',
        ];
    }
}
