<?php

namespace App\Http\Requests;

use App\Rules\PaymentMethodRequired;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseReturnRequest extends FormRequest
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
            'detail_id' => 'required|exists:purchase_details,id', // Assuming your model is PurchaseDetails
            'payment_method_id' => [new PaymentMethodRequired($this->input('returnAmount'))], // Payment method is required if returnAmount > 0
            'returnAmount' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ];
    }
}
