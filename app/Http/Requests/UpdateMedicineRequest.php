<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
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
        $selfId = $this->route('medicine')->id;

        return [
            'pharmacy_id' => 'nullable',
            'barcode' => 'required|max:255|unique:medicines,barcode,'.$selfId,
            'generic' => 'required|max:255',
            'name' => 'required',
            'manufacturer_id' => 'required',
            'leaf_id' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'type_id' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
