<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'pharmacy_name' => 'required|string|max:255',
            'pharmacy_phone' => 'required|unique:pharmacies,mobile_no',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'terms_and_conditions' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!',
            'terms_and_conditions.required' => 'You must agree to the Terms and Condition!',
        ];
    }
}
