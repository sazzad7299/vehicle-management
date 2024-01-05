<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class StoreSalePaymentRequest extends FormRequest
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
        return [
            'sale_id' => 'required|exists:sales,id', // Assuming your model is PurchaseDetails
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
            'paid' => 'required|numeric|min:1',
            'discount' => 'nullable|integer',
        ];
    }
}
