<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Log;

class MessageClient
{
    public function __construct(
        private $language = 'bg',
        private $successCount = 0,
        private $clientEmailList = [],
    ) {
        $this->language = config('app.locale', 'bg');
    }
    /**
     * Broadcast message to selected clients.
     *
     * @param string $message
     * @param array $clients
     * @return array
     */
    public function handle(string $message, array $clients): array
    {
        foreach ($clients as $clientData) {
            $client = Client::find($clientData['id']);

            if ($client) {

                // Send email to client
                SendEmail::dispatch($client->email, $message, $this->language, 'client');
                $this->successCount++;
                $this->clientEmailList[] = $client->email;
            } else {

                Log::warning('Client not found for messaging', [
                    'client_id' => $clientData['id']
                ]);
            }
        }

        // Send report message to admin
        $adminMessage = $this->language === 'bg'
            ? "Администраторско известие: Изпратено е съобщение до {$this->successCount} клиент(и): " . implode(', ', $this->clientEmailList)
            : "Admin Notice: Message sent to {$this->successCount} client(s): " . implode(', ', $this->clientEmailList);

        SendEmail::dispatch(config('mail.admin_email'), $adminMessage, $this->language, 'admin');

        return [
            'success' => true,
            'count' => $this->successCount,
            'message' => "Съобщението е изпратено успешно до {$this->successCount} клиент(и)!"
        ];
    }
}
