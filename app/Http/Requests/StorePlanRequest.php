<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:255|unique:plans,name',
            'slug' => 'required|min:2|max:255|unique:plans,slug',
            'monthly' => 'required|integer',
            'annually' => 'required|integer',
            'image' => 'nullable',
            'description' => 'nullable',
            'features.*.title' => 'required',
            'features.*.model' => 'required',
            'features.*.quote' => 'required|integer',
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
            'monthly.required' => 'Plan monthly is required',
            'monthly.integer' => 'Plan monthly must be an integer',
            'annually.required' => 'Plan annually is required',
            'annually.integer' => 'Plan annually must be an integer',
            'image.mimes' => 'Plan image must be a jpeg, jpg, or png',
            'features.*.title.required' => 'Features Title is required',
            'features.*.model.required' => 'Features Model is required',
            'features.*.quote.required' => 'Features Quote is required',
            'features.*.quote.integer' => 'Features Quote must be number',

        ];
    }
}
