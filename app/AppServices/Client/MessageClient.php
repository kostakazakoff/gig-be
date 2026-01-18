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
                // Log::info('Broadcasting message to clients', [
                //     'message' => $message,
                //     'client' => $client->first_name . ' ' . $client->last_name
                // ]);

                SendEmail::dispatch($client->email, $message, $this->language, 'client');
                $this->successCount++;
            }
            
            $adminMessage = $this->language === 'bg'
                ? "Администраторско известие: Изпратено е съобщение до {$this->successCount} клиент(и)."
                : "Admin Notice: Message sent to {$this->successCount} client(s).";

            SendEmail::dispatch(config('mail.admin_email'), $adminMessage, $this->language, 'admin');
        }

        return [
            'success' => true,
            'count' => $this->successCount,
            'message' => "Съобщението е изпратено успешно до {$this->successCount} клиент(и)!"
        ];
    }
}
