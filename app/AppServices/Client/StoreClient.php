<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Traits\CreateAvatar;
use Illuminate\Http\Request;

class StoreClient
{
    use CreateAvatar;

    public function handle(Request $request): Client
    {
        $client = Client::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name ?? null,
            'email'      => $request->email,
            'phone'      => $request->phone ?? null,
            'address'    => $request->address ?? null,
            'company'    => $request->company ?? null,
        ]);

        if ($request->image ?? null) {
            $this->createAvatar($client, [$request->image], 'client_avatars');
        }

        return $client;
    }
}
