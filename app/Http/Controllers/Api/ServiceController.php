<?php

namespace App\Http\Controllers\Api;

use App\AppServices\Service\ListServices;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    use \App\Traits\HttpResponses;

    /**
     * Display a listing of all services.
     * GET - за NEXT.js фронтенд (AJAX)
     */
    public function index(string $categoryId, ListServices $listServices)
    {
        $services = $listServices->handle($categoryId);
        
        return $this->success($services);
    }
}
