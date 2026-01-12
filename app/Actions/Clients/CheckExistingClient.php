<?php

namespace App\Actions\Clients;

use App\Models\Client;

class CheckExistingClient
{
    public function handle(?string $email): ?Client
    {
        if (!$email) {
            return null;
        }
        
        return Client::where('email', $email)->first();
    }
}