<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'key' => 'required|string|max:50|regex:/^[a-z0-9_-]+$/|unique:news,translation_key',
            'title_en' => 'required|string|max:255',
            'title_bg' => 'required|string|max:255',
            'content_en' => 'required|string',
            'content_bg' => 'required|string',
        ];
    }

    /**
     * Get custom error messages for validator
     */
    public function messages(): array
    {
        return [
            'key.regex' => 'Key must contain only lowercase letters, numbers, underscores and hyphens (a-z, 0-9, _, -)',
            'key.unique' => 'This key already exists',
            'key.required' => 'Key is required',
            'title_en.required' => 'English title is required',
            'title_bg.required' => 'Bulgarian title is required',
            'content_en.required' => 'English content is required',
            'content_bg.required' => 'Bulgarian content is required',
        ];
    }
}
