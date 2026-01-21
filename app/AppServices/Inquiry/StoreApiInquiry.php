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
    )
    {
        $this->language = config('app.locale', $language);
    }
    
    public function handle(StoreInquiryRequest $request): array
    {
        $client = $this->checkExistingClient->handle($request->email);
        $isNewClient = !$client;

        if (!$isNewClient) {
            $this->language = $client->language;
        }

        if ($isNewClient) {
            $client = $this->storeClient->handle($request);
        }

        $message = __('messages.client_success_message', [], $this->language);

        // TODO: fix admin language to be dynamic when Admin Panel with language settings is implemented
        $adminMessage = ($isNewClient ? __('messages.admin_new_client_message', [], 'bg') : __('messages.admin_existing_client_message', [], 'bg'));
        
        $successMessage = __('messages.success_response', [], $this->language);
        
        $inquiry = Inquiry::create([
            'client_id' => $client->id,
            'message' => $request->message,
            'category_id' => $request->category ?? null,
        ]);

        // Respond to client and notify admin
        SendEmail::dispatch($client->email, $message, $this->language, 'client');

        // TODO: fix admin language to be dynamic when Admin Panel with language settings is implemented
        SendEmail::dispatch(config('mail.admin_email'), $adminMessage, 'bg', 'admin');

        return [
            'inquiry' => $inquiry,
            'success_message' => $successMessage,
        ];
    }
}