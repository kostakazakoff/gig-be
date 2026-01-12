<?php

namespace App\AppServices\Inquiry;

use App\Actions\Clients\CheckExistingClient;
use App\Http\Requests\Inquiry\StoreInquiryRequest;
use App\Jobs\SendEmail;
use App\AppServices\Client\StoreClient;
use App\Models\Inquiry;

class StoreApiInquiry
{
    public function __construct(
        public CheckExistingClient $checkExistingClient,
        public StoreClient $storeClient,
        private $language = 'en',
    )
    {
        $this->language = config('app.locale', 'en') ?? $this->language;
    }

    public function handle(StoreInquiryRequest $request): array
    {
        $client = $this->checkExistingClient->handle($request->email);
        $newClient = null;

        if (! $client) {
            $client = $this->storeClient->handle($request);
            $newClient = 'Нов клиент';
        } else {
            $newClient = 'Ваш клиент';
        }

        // $request->validate([
        //     'message' => 'required|string',
        //     'language' => 'required|string|max:2',
        // ]);


        $message = $this->language === 'bg'
            ? 'Уважаеми клиенти, благодарим Ви, че се свързахте с нас! Нашият екип ще се свърже с Вас, възможно най-скоро.'
            : 'Dear Customers, thank you for the inquiry! Our team will get back to you as soon as possible.';

        $adminMessage = $newClient.' е изпратил съобщение чрез формата за контакт.';

        $successMessage = $this->language === 'bg'
            ? 'Информацията за клиента е получена успешно.'
            : 'Client information received successfully.';

        $inquiry = Inquiry::create([
            'client_id' => $client->id,
            'message' => $request->input('message'),
            'category' => $request->input('category') ?? null,
        ]);

        // Respond to client and notify admin
        SendEmail::dispatch($client->email, $message, $this->language, 'client');
        SendEmail::dispatch(config('mail.admin_email'), $adminMessage, $this->language, 'admin');

        return [
            'inquiry' => $inquiry,
            'success_message' => $successMessage,
        ];
    }
}