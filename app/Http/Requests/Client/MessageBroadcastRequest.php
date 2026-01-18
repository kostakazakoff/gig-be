<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class MessageBroadcastRequest extends FormRequest
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
            'messages' => 'required|array',
            'messages.bg' => 'required|string',
            'messages.en' => 'required|string',
            'clientsByLanguage' => 'required|array',
            'clientsByLanguage.bg' => 'array',
            'clientsByLanguage.en' => 'array',
            'clients' => 'required|array',
            'clients.*.id' => 'required|exists:clients,id',
            'clients.*.email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'messages.required' => 'Съобщенията са задължителни.',
            'messages.bg.required' => 'Съобщението на български е задължително.',
            'messages.en.required' => 'Съобщението на английски е задължително.',
            'clients.required' => 'Трябва да изберете поне един клиент.',
            'clients.array' => 'Невалиден формат за клиентите.',
            'clients.*.id.exists' => 'Избраният клиент не съществува.',
            'clients.*.email.email' => 'Невалиден имейл адрес за клиент.',
        ];
    }
}
