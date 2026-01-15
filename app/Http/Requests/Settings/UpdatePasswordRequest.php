<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail(__('auth.password'));
                    }
                },
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
                function ($attribute, $value, $fail) {
                    if ($this->current_password === $value) {
                        $fail(__('passwords.new_password_must_be_different'));
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Въвведете текущата парола.',
            'password.required' => 'Въведете новата парола.',
            'password.min' => 'Новата парола трябва да е поне :min символа.',
            'password.confirmed' => 'Потвърждението на новата парола не съвпада.',
        ];
    }
}
