<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
        if (empty($pharmacyId)) {
            $pharmacyId = $this->input('pharmacy_id');
        }

        return [
            'pharmacy_id' => 'nullable',
            'name' => [
                'required',
                'max:255',
                Rule::notIn(['Walking Customer']),
            ],
            'phone' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:customers,phone,NULL,id,pharmacy_id,'.$pharmacyId,
            'email' => 'nullable|email|unique:customers,phone,NULL,id,pharmacy_id,'.$pharmacyId,
            'image' => 'nullable',
            'address' => 'nullable',
            'note' => 'nullable',
            'status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'name.not_in' => 'The name cannot be "Walking Customer".',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone number must not exceed 11 characters.',
            'phone.regex' => 'Invalid phone number format. It should start with "01" followed by 9 digits.',
            'phone.unique' => 'This phone number is already associated with another customer.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email is already associated with another customer.',
            'image.image' => 'Invalid file format for the image. Please upload a valid image file.',
            'address.max' => 'The address must not exceed the maximum allowed characters.',
            'note.max' => 'The note must not exceed the maximum allowed characters.',
            'status' => 'Invalid status format.', // Adjust the message based on your specific status validation.
        ];
    }
}
