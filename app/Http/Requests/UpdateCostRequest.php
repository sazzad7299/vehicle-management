<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCostRequest extends FormRequest
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
            'cost_category_id' => 'nullable|exists:cost_categories,id',
            'name' => 'required',
            'amount' => 'required',
            'cost_by' => 'nullable',
            'payment_method_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('amount') > 0) {
                        if (! PaymentMethod::where('id', $value)->exists()) {
                            $fail('The selected payment method is invalid.');
                        }
                    }
                },
            ],
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'note' => 'nullable',
            'date' => 'nullable|date|before_or_equal:today',
        ];
    }
}
