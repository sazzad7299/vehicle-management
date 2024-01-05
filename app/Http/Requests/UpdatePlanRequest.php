<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'name' => 'required|min:2|max:255|unique:plans,name,'.$this->plan->id,
            'slug' => 'required|min:2|max:255|unique:plans,slug,'.$this->plan->id,
            'price' => 'required|integer',
            'duration_type' => 'required',
            'duration' => 'required|integer|between:1,1000',
            'image' => 'nullable',
            'description' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Plan name is required',
            'name.min' => 'Plan name must be at least 2 characters',
            'name.max' => 'Plan name must be less than 255 characters',
            'name.unique' => 'Plan name already exists',
            'slug.required' => 'Plan slug is required',
            'slug.min' => 'Plan slug must be at least 2 characters',
            'slug.max' => 'Plan slug must be less than 255 characters',
            'slug.unique' => 'Plan slug already exists',
            'price.required' => 'Plan price is required',
            'price.integer' => 'Plan price must be an integer',
            'price.between' => 'Plan price must be between 1 and 1000000',
            'duration_type.required' => 'Select a Plan duration type',
            'duration.required' => 'Plan duration is required',
            'duration.integer' => 'Plan duration must be an integer',
            'duration.between' => 'Plan duration must be between 1 and 1000',
            'image.mimes' => 'Plan image must be a jpeg, jpg, or png',
        ];
    }
}
