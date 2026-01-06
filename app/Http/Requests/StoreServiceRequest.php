<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'key' => 'required|string|max:50|regex:/^[a-z0-9_]+$/|unique:services,translation_key',
            'name_en' => 'required|string|max:255',
            'name_bg' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_bg' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];
    }

    /**
     * Get custom error messages for validator
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'key.regex' => 'Key must contain only lowercase letters, numbers and underscores (a-z, 0-9, _)',
            'key.unique' => 'This key already exists',
            'key.required' => 'Key is required',
            'name_en.required' => 'English name is required',
            'name_bg.required' => 'Bulgarian name is required',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, png or webp',
        ];
    }
}
