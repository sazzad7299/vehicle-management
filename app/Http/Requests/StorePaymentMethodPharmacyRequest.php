<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodPharmacyRequest extends FormRequest
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
        $pharmacyId = $this->input('pharmacy_id');

        return [
            'pharmacy_id' => 'required',
            'payment_method_id' => 'required|max:255|unique:payment_method_pharmacies,payment_method_id,NULL,id,pharmacy_id,'.$pharmacyId,
            'priority' => 'required|max:255|unique:payment_method_pharmacies,priority,NULL,id,pharmacy_id,'.$pharmacyId,
            'status' => 'required',
        ];
    }
}
