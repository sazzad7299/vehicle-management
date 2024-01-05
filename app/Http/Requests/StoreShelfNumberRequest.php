<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShelfNumberRequest extends FormRequest
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
        $pharmacyId = auth('sanctum')->user()->pharmacy_id;

        return [
            'pharmacy_id' => 'nullable',
            'name' => 'required|max:255|unique:shelf_numbers,name,NULL,id,pharmacy_id,'.$pharmacyId,
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
