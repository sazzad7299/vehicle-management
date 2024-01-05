<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCostCategoryRequest extends FormRequest
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
            'name' => 'required|max:255|unique:cost_categories,name,NULL,id,pharmacy_id,'.$pharmacyId,
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
