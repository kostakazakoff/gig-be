<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id ?? $this->route('client');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($clientId),
            ],
            'phone'      => ['nullable', 'string', 'max:255'],
            'address'    => ['nullable', 'string'],
            'company'    => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.string' => 'First name must be a string',
            'first_name.max' => 'First name must not exceed 255 characters',
            
            'last_name.string' => 'Last name must be a string',
            'last_name.max' => 'Last name must not exceed 255 characters',
            
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not exceed 255 characters',
            'email.unique' => 'This email address is already registered',
            
            'phone.string' => 'Phone must be a valid phone number',
            'phone.max' => 'Phone must not exceed 255 characters',
            
            'address.string' => 'Address must be a string',
            
            'company.string' => 'Company must be a string',
            'company.max' => 'Company must not exceed 255 characters',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, jpg, png or webp',
            'image.max' => 'Image must not exceed 2MB',
        ];
    }
}
