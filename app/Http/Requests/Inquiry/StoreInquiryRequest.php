<?php

namespace App\Http\Requests\Inquiry;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'  => ['nullable', 'exists:clients,id'],
            'first_name' => ['string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'service_id' => ['nullable', 'exists:services,id'],
            'message'    => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Message is required',
            'message.string' => 'Message must be a string',
            
            'client_id.exists' => 'Selected client does not exist',
            'client_id.integer' => 'Client ID must be an integer',
            
            'service_id.exists' => 'Selected service does not exist',
            'service_id.integer' => 'Service ID must be an integer',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',

            'first_name.string' => 'First name must be a string',
            'first_name.max' => 'First name must not exceed 255 characters',

            'last_name.string' => 'Last name must be a string',
            'last_name.max' => 'Last name must not exceed 255 characters',

            'phone.string' => 'Phone must be a string',
            'phone.max' => 'Phone must not exceed 20 characters',
        ];
    }
}
