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
        //
    }
    /**
     * Broadcast message to selected clients based on their language.
     *
     * @param array $messages Array with 'bg' and 'en' keys
     * @param array $clientsByLanguage Array organized by language
     * @return array
     */
    public function handle(array $messages, array $clientsByLanguage): array
    {

        // Send Bulgarian messages
        if (!empty($clientsByLanguage['bg'])) {
            foreach ($clientsByLanguage['bg'] as $clientData) {
                $client = Client::find($clientData['id']);
                if ($client) {

                    // Send email to client
                    SendEmail::dispatch($client->email, $messages['bg'], 'bg', 'client');
                    $this->successCount++;
                    $this->clientEmailList[] = $client->email;
                } else {

                    Log::warning('Client not found for messaging', [
                        'client_id' => $clientData['id']
                    ]);
                }
            }
        }

        // Send English messages
        if (!empty($clientsByLanguage['en'])) {
            foreach ($clientsByLanguage['en'] as $clientData) {
                $client = Client::find($clientData['id']);
                if ($client) {
                    // Send email to client
                    SendEmail::dispatch($client->email, $messages['en'], 'en', 'client');
                    $this->successCount++;
                    $this->clientEmailList[] = $client->email;
                } else {

                    Log::warning('Client not found for messaging', [
                        'client_id' => $clientData['id']
                    ]);
                }
            }
        }

        $message = "Съобщението е изпратено успешно до {$this->successCount} клиент(и)!";

        $adminMessage = $this->language === 'bg'
            ? "Администраторско известие: Изпратено е съобщение до {$this->successCount} клиент(и): " . implode(', ', $this->clientEmailList)
            : "Admin Notice: Message sent to {$this->successCount} client(s): " . implode(', ', $this->clientEmailList);

        SendEmail::dispatch(config('mail.admin_email'), $adminMessage, $this->language, 'admin');

        return [
            'success' => true,
            'count' => $this->successCount,
            'message' => $message
        ];
    }
}
