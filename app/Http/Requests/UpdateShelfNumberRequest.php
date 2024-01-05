<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShelfNumberRequest extends FormRequest
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
        $selfId = $this->route('shelf')->id; // assuming the route model binding is used
        $pharmacyId = auth('sanctum')->user()->pharmacy_id;

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('shelf_numbers')->ignore($selfId)->where(function ($query) use ($pharmacyId) {
                    return $query->where('pharmacy_id', $pharmacyId);
                }),
            ],
            'description' => 'nullable',
            'status' => 'required',
        ];
    }
}
