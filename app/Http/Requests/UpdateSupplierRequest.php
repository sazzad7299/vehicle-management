<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $selfId = $this->route('supplier')->id; // assuming the route model binding is used
        $pharmacyId = auth('sanctum')->user()->pharmacy_id;

        return [
            'pharmacy_id' => 'nullable',
            'name' => [
                'required',
                'max:255',
                Rule::unique('suppliers')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'email' => [
                'nullable',
                'max:255',
                Rule::unique('suppliers')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'phone' => [
                'required',
                'max:11',
                'regex:/(01)[0-9]{9}/',
                Rule::unique('suppliers')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'company' => 'nullable',
            'company_phone' => [
                'nullable',
                'max:11',
                'regex:/(01)[0-9]{9}/',
                Rule::unique('suppliers')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'image' => 'nullable',
            'address' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
