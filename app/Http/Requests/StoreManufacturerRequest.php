<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManufacturerRequest extends FormRequest
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
        return [
            'name' => 'required|max:255|unique:manufacturers,name,',
            'email' => 'nullable|email|unique:manufacturers,email,',
            'phone' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:manufacturers,phone,',
            'address' => 'nullable',
            'photo' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
