<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Traits\CreateThumbnail;

class StoreClient
{
    use CreateThumbnail;

    public function handle(array $data): Client
    {
        $client = Client::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'address'    => $data['address'] ?? null,
            'company'    => $data['company'] ?? null,
        ]);

        if ($data['image'] ?? null) {
            $this->createThumbnail($client, [$data['image']], 'category_thumbs');
        }

        return $client;
    }
}
