<?php

namespace App\AppServices\Client;

use App\Models\Client;
use App\Traits\CreateThumbnail;
use Illuminate\Http\Request;

class StoreClient
{
    use CreateThumbnail;

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
            $this->createThumbnail($client, [$request->image], 'client_thumbs');
        }

        return $client;
    }
}
