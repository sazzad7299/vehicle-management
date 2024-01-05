<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePharmacyRequest extends FormRequest
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
        $selfId = $this->route('pharmacy')->id;

        return [
            'company_name' => 'required|min:2|max:255',
            'mobile_no' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:pharmacies,mobile_no,'.$selfId,
            'website' => 'nullable',
            'country' => 'nullable',
            'division_id' => 'nullable',
            'district_id' => 'nullable',
            'upazilas_id' => 'nullable',
            'union_id' => 'nullable',
            'zip_code' => 'nullable',
            'street_address' => 'nullable',
            'google_map_location' => 'nullable',
            'reffer_by_name' => 'nullable',
            'reffer_by_phone' => 'nullable|max:11|regex:/(01)[0-9]{9}/',
            'note' => 'nullable',
            'logo' => 'nullable',
        ];
    }
}
