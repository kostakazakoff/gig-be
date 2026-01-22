<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:clients,email'],
            'phone'      => ['nullable', 'string', 'max:255'],
            'address'    => ['nullable', 'string'],
            'company'    => ['nullable', 'string', 'max:255'],
            'site'       => ['nullable', 'url', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'language'   => ['required', 'string', 'in:bg,en'],
        ];
    }

    public function messages(): array
    {
        return trans('validation.messages');
    }
}
