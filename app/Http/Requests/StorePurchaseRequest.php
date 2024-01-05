<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
        $pharmacyId = $this->input('pharmacy_id');

        return [
            'purchaseProducts' => 'required|array',
            'purchaseProducts.*.id' => 'required',
            'purchaseProducts.*.barcode' => 'required',
            'purchaseProducts.*.expire_date' => 'required',
            'purchaseProducts.*.name' => 'required',
            'purchaseProducts.*.quantity' => 'required|numeric',
            'purchaseProducts.*.pp' => 'required|numeric',
            'purchaseProducts.*.mrp' => 'required|numeric',
            'purchaseProducts.*.subtotal' => 'required|numeric',
            'purchaseProducts.*.discount' => 'required|numeric|max:100|min:0',
            'purchaseProducts.*.total' => 'required|numeric',
            'purchase.subtotal' => 'required|numeric',
            'purchase.medicine_discount' => 'required|numeric',
            'purchase.total' => 'required|numeric',
            'purchase.invoice_discount_amount' => 'required|numeric',
            'purchase.paid' => 'required|numeric',
            'purchase.due' => 'required|numeric',
            'purchase.total_quantity' => 'required|numeric',
            'purchase.payment_method_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('paid') > 0) {
                        if (! PaymentMethod::where('id', $value)->exists()) {
                            $fail('The selected payment method is invalid.');
                        }
                    }
                },
            ],
            'purchase.invoice_discount_type' => 'required',
            'purchase.supplier_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'saleProducts.required' => 'At least one sale product is required.',
            'saleProducts.min' => 'At least one sale product is required.', // This message will be shown when there are no sale products provided
            'purchaseProducts.*.quantity.min' => 'Select payment Method',
            'purchase.payment_method_id.required' => 'Select payment Method',
            'purchase.supplier_id.required' => 'Supplier is required for purchase',
        ];
    }
}
