<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $selfId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11|regex:/(01)[0-9]{9}/|unique:users,phone,'.$selfId,
            'email' => 'required|string|email|unique:users,email,'.$selfId,
            'country_id' => 'required|exists:countries,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazilas_id' => 'required|exists:upazilas,id',
            'union_id' => 'required|exists:unions,id',
            'role_id' => 'required|exists:roles,id',
            'zip_code' => 'required|numeric',
            'image' => 'nullable',
            'user_status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name  is required.',
            'phone.required' => 'The phone field is required.',
            'pharmacy_id.required' => 'The pharmacy field is required.',
            'pharmacy_id.exists' => 'The selected pharmacy is invalid.',
            'email.required' => 'The email field is required.',
            'country_id.required' => 'The country field is required.',
            'division_id.required' => 'The division field is required.',
            'district_id.required' => 'The district field is required.',
            'upazilas_id.required' => 'The upazila field is required.',
            'union_id.required' => 'The union field is required.',
            'zip_code.required' => 'The zip code field is required.',
            'image.required' => 'The image field is required.',
            'role_id.required' => 'The Role field is required.',
        ];
    }
}
