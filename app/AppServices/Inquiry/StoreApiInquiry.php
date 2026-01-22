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
        private $language = 'bg',
        private $adminLanguage = 'bg',
        private $adminMessage = '',
    ) {
        $this->language = config('app.locale', $language);
    }

    public function handle(StoreInquiryRequest $request): array
    {
        $client = $this->checkExistingClient->handle($request->email);
        $isNewClient = !$client;

        switch ($isNewClient) {
            case true:
                $this->language = $request->language ?? config('app.locale', 'bg');
                $client = $this->storeClient->handle($request);
                $this->adminMessage = __('messages.admin_new_client_message', [], $this->adminLanguage);
                break;
            case false:
                $this->language = $client->language;
                $this->adminMessage = __('messages.admin_existing_client_message', [], $this->adminLanguage);
                break;
        }

        $message = __('messages.client_success_message', [], $this->language);

        $successMessage = __('messages.success_response', [], $this->language);

        $inquiry = Inquiry::create([
            'client_id' => $client->id,
            'message' => $request->message,
            'category_id' => $request->category ?? null,
        ]);

        // Respond to client and notify admin
        SendEmail::dispatch($client->email, $message, $this->language, 'client');

        // TODO: fix admin language to be dynamic when Admin Panel with language settings is implemented
        SendEmail::dispatch(config('mail.admin_email'), $this->adminMessage, $this->adminLanguage, 'admin');

        return [
            'inquiry' => $inquiry,
            'success_message' => $successMessage,
        ];
    }
}
