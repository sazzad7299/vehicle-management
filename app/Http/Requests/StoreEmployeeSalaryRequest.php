<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use App\Rules\MonthlySalaryValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeSalaryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $pharmacyId = auth()->user()->pharmacy_id;

        return [
            'pharmacy_id' => 'nullable',
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'date' => [
                'required',
                'date', // You can add more date validation rules as needed
                new MonthlySalaryValidation(
                    $this->input('employee_id'),
                    $this->input('paid'),
                    $this->input('date')
                ),
            ],
            'paid' => 'required|numeric|min:1',
            'payment_method_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('paid') > 0) {
                        if (! PaymentMethod::where('id', $value)->exists()) {
                            $fail('The selected payment method is invalid.');
                        }
                    }
                },
            ],
        ];
    }
}
