<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
        $pharmacyId = auth()->user()->pharmacy_id;

        return [
            'pharmacy_id' => 'nullable',
            'name' => 'required|max:255|unique:suppliers,name,NULL,id,pharmacy_id,'.$pharmacyId,
            'phone' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:suppliers,phone,NULL,id,pharmacy_id,'.$pharmacyId,
            'email' => 'nullable',
            'company' => 'nullable',
            'company_phone' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:suppliers,company_phone,NULL,id,pharmacy_id,'.$pharmacyId,
            'image' => 'nullable',
            'address' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
