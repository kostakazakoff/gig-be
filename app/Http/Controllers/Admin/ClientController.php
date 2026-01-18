<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\AppServices\Client\StoreClient;
use App\AppServices\Client\UpdateClient;
use App\AppServices\Client\MessageClient;
use App\Http\Requests\Client\MessageBroadcastRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = Client::query()
            ->withCount('inquiries')
            ->latest()
            ->get();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(StoreClientRequest $request, StoreClient $service)
    {
        $service->handle($request->validated());

        return redirect()->route('admin.clients.index')
            ->with('success', __('messages.client_created_successfully'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(UpdateClientRequest $request, Client $client, UpdateClient $service)
    {
        $service->handle($client, $request->validated());

        return redirect()->route('admin.clients.index')
            ->with('success', __('messages.client_updated_successfully'));
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', __('messages.client_deleted_successfully'));
    }

    /**
     * Delete a specific image from a client
     */
    public function deleteImage(Client $client)
    {
        if ($client->hasMedia('client_avatars')) {
            $client->clearMediaCollection('client_avatars');

            return response()->json([
                'success' => true,
                'message' => __('messages.image_deleted_successfully')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('messages.image_not_found')
        ], 404);
    }

    /**
     * Broadcast message to selected clients.
     */
    public function messageBroadcast(MessageBroadcastRequest $request, MessageClient $service)
    {
        $result = $service->handle(
            $request->input('messages'),
            $request->input('clientsByLanguage'),
            // $request->input('clients')
        );

        return response()->json($result);
    }
}
