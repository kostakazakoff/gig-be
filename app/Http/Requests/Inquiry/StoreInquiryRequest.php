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
        ];
    }
}
