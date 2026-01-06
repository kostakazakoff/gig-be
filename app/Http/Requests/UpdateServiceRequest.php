<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name_en.required' => 'English name is required',
            'name_bg.required' => 'Bulgarian name is required',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, png or webp',
        ];
    }
}
