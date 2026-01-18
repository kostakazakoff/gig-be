<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Traits\CreateAvatar;

class StoreClient
{
    use CreateAvatar;

    public function handle($clientData): Client
    {
        $client = Client::create([
            'first_name' => $clientData['first_name'],
            'last_name'  => $clientData['last_name'] ?? null,
            'email'      => $clientData['email'],
            'phone'      => $clientData['phone'] ?? null,
            'address'    => $clientData['address'] ?? null,
            'company'    => $clientData['company'] ?? null,
            'site'       => $clientData['site'] ?? null,
            'language'   => $clientData['language'] ?? 'bg',
        ]);

        if ($clientData['image'] ?? null) {
            $this->createAvatar($client, [$clientData['image']], 'client_avatars');
        }

        return $client;
    }
}
