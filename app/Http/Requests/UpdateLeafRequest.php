<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeafRequest extends FormRequest
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
        $selfId = $this->route('leaf')->id; // assuming the route model binding is used
        // $pharmacyId = $this->input('pharmacy_id');

        return [
            'pharmacy_id' => 'nullable',
            'leaf_type' => 'required|max:255|unique:leaves,leaf_type,'.$selfId,
            'number_per_box' => 'required',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
