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
        private $clients = [],
        private $messages = [],
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
        $this->messages = $messages;
        $this->clients = $clientsByLanguage;

        // Send Bulgarian messages
        if (!empty($this->clients['en'])) {

            $this->sendEmailToClient('en');
        }
        
        if (!empty($this->clients['bg'])) {

            $this->sendEmailToClient('bg');
        } 
        
        if ($this->successCount === 0) {

            Log::warning('No clients found for messaging');
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

    private function sendEmailToClient(string $clientLanguage): void
    {
        foreach ($this->clients[$clientLanguage] as $clientData) {
            $client = Client::find($clientData['id']);

            if ($client) {

                // Send email to client
                SendEmail::dispatch($client->email, $this->messages[$clientLanguage], $clientLanguage, 'client');
                $this->successCount++;
                $this->clientEmailList[] = $client->email;
            } else {

                Log::warning('Client not found for messaging', [
                    'client_id' => $clientData['id']
                ]);
            }
        }
    }
}
