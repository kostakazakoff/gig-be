<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|max:255|regex:/^[a-zа-я\s]+$/ui',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
        ];
    }

public function messages(): array
{
    return [
        'name.required' => 'Потребителското име е задължително.',
        'name.max' => 'Потребителското име не трябва да надвишава 255 символа.',
        'name.regex' => 'Потребителското име може да съдържа само букви и спейсове.',
        'email.required' => 'Имейлът е задължителен.',
        'email.email' => 'Имейлът трябва да е валиден.',
        'email.unique' => 'Този имейл вече е регистриран.',
    ];
    }
}
