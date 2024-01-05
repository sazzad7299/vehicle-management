<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManufacturerRequest extends FormRequest
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
        $selfId = $this->route('manufacturer')->id; // assuming the route model binding is used

        return [
            'name' => 'required|max:255|unique:manufacturers,name,'.$selfId,
            'email' => 'nullable|email|unique:manufacturers,email,'.$selfId,
            'phone' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:manufacturers,phone,'.$selfId,
            'address' => 'nullable',
            'logo' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
