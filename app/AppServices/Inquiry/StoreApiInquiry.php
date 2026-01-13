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
        $this->language = config('app.locale', 'en');
    }
    

    public function handle(StoreInquiryRequest $request): array
    {
        $client = $this->checkExistingClient->handle($request->email);
        $isNewClient = !$client;

        if ($isNewClient) {
            $client = $this->storeClient->handle($request);
        }

        $message = __('inquiry.client_success_message');
        $adminMessage = ($isNewClient ? __('inquiry.admin_new_client_message') : __('inquiry.admin_existing_client_message'));
        $successMessage = __('inquiry.success_response');
        
        $inquiry = Inquiry::create([
            'client_id' => $client->id,
            'message' => $request->message,
            'category_id' => $request->category ?? null,
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