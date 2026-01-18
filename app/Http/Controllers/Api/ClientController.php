<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use HttpResponses;
    public function getClients(): JsonResponse
    {
        $clients = Client::all();
        return $this->success($clients, 'Clients retrieved successfully');
    }
}
