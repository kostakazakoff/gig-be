<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'key' => 'required|string|max:50|regex:/^[a-z0-9_]+$/|unique:categories,translation_key',
            'name_en' => 'required|string|max:255',
            'name_bg' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_bg' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator
     */
    public function messages(): array
    {
        return [
            'key.regex' => 'Key must contain only lowercase letters, numbers and underscores (a-z, 0-9, _)',
            'key.unique' => 'This key already exists',
            'key.required' => 'Key is required',
            'name_en.required' => 'English name is required',
            'name_bg.required' => 'Bulgarian name is required',
        ];
    }
}
