<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11|regex:/(01)[0-9]{9}/|unique:users,phone',
            'pharmacy_id' => 'nullable | exists:pharmacies,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'country_id' => 'required|exists:countries,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazilas_id' => 'required|exists:upazilas,id',
            'union_id' => 'required|exists:unions,id',
            'role_id' => 'required|exists:roles,id',
            'zip_code' => 'required|numeric',
            'image' => 'nullable',

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
            'password.required' => 'The password field is required.',
            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.same' => 'The password confirmation and password must match.',
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
