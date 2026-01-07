<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\HttpResponses;
use App\AppServices\IndexServices;
use App\AppServices\GetCategories;
use App\AppServices\GetUnits;
use App\AppServices\StoreService;
use App\AppServices\UpdateService;
use App\AppServices\DestroyService;

class ServiceController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of all services.
     * GET - връща view със таблица
     */
    public function index(IndexServices $indexServices)
    {
        $services = $indexServices->handle();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * GET - връща view с форма
     */
    public function create(GetCategories $getCategories, GetUnits $getUnits)
    {
        $categories = $getCategories->handle();
        $units = $getUnits->handle();
        return view('admin.services.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     * POST - обработка от Blade форма
     */
    public function store(StoreServiceRequest $request, StoreService $service)
    {
        $service->handle($request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     * GET - връща view с форма
     */
    public function edit(Service $service, GetCategories $getCategories, GetUnits $getUnits)
    {
        $categories = $getCategories->handle();
        $units = $getUnits->handle();
        
        return view('admin.services.edit', compact('service', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH - обработка от Blade форма
     */
    public function update(UpdateServiceRequest $request, Service $service, UpdateService $updateService)
    {
        $updateService->handle($service, $request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }
}
