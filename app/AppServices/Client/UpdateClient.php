<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Traits\CreateThumbnail;

class UpdateClient
{
    use CreateThumbnail;

    public function handle(Client $client, array $data): Client
    {
        $updateData = [
            'first_name' => $data['first_name'] ?? $client->first_name,
            'last_name'  => $data['last_name'] ?? $client->last_name,
            'email'      => $data['email'] ?? $client->email,
        ];

        if (array_key_exists('phone', $data)) {
            $updateData['phone'] = $data['phone'];
        }
        if (array_key_exists('address', $data)) {
            $updateData['address'] = $data['address'];
        }
        if (array_key_exists('company', $data)) {
            $updateData['company'] = $data['company'];
        }

        $client->update($updateData);

        if ($data['image'] ?? null) {
            $this->createThumbnail($client, [$data['image']], 'client_thumbs');
        }

        return $client;
    }
}
