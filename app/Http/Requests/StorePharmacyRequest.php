<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePharmacyRequest extends FormRequest
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
            // For pharmacy table
            'user_id' => 'required',
            'company_name' => 'required|min:2|max:255',
            'mobile_no' => 'required|max:11|regex:/(01)[0-9]{9}/|unique:pharmacies,mobile_no',
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

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user field is required.',
            'company_name.required' => 'The name field is required.',
            'mobile_no.required' => 'The mobile no field is required.',
            'website.required' => 'The website field is required.',
            'country.required' => 'The country field is required.',
            'division_id.required' => 'The division field is required.',
            'district_id.required' => 'The district field is required.',
            'upazilas_id.required' => 'The upazila field is required.',
            'union_id.required' => 'The union field is required.',
            'zip_code.required' => 'The zip code field is required.',
            'street_address.required' => 'The street address field is required.',
            'google_map_location.required' => 'The google map location field is required.',
            'reffer_by_name.required' => 'The reffer by name field is required.',
            'reffer_by_phone.required' => 'The reffer by phone field is required.',
            'note.required' => 'The note field is required.',
            'logo.required' => 'The logo field is required.',
            'status.required' => 'The status field is required.',
        ];
    }
}
