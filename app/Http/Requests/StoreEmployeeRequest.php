<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pharmacyId = auth('sanctum')->user()->pharmacy_id;

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11|regex:/(01)[0-9]{9}/|unique:employees,phone,NULL,id,pharmacy_id,'.$pharmacyId,
            'pharmacy_id' => 'nullable | exists:pharmacies,id',
            'email' => 'required|string|email|max:255|unique:employees,email,NULL,id,pharmacy_id,'.$pharmacyId,
            'country_id' => 'required|exists:countries,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazilas_id' => 'required|exists:upazilas,id',
            'union_id' => 'required|exists:unions,id',
            'zip_code' => 'required|numeric',
            'salary' => 'required|numeric',
            'image' => 'nullable',
            'nid' => 'required',
            'joining_date' => 'required|date',
            'leave_date' => 'nullable|date',
        ];
    }
}
