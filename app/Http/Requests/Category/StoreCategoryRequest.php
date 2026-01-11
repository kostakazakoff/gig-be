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
            'key.regex' => 'Ключът може да съдържа само малки букви, цифри и долни черти',
            'key.unique' => 'Този ключ вече съществува',
            'key.required' => 'Ключът е задължителен',
            'name_en.required' => 'Името на английски е задължително',
            'name_bg.required' => 'Името на български е задължително',
        ];
    }
}
