<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTypeRequest extends FormRequest
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
        $selfId = $this->route('type')->id; // assuming the route model binding is used

        return [
            'pharmacy_id' => 'nullable',
            'name' => 'required|unique:types,name,'.$selfId,
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
