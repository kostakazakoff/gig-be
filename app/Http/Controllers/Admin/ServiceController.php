<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Category;
use App\Http\Filters\ServiceFilter;
use App\Traits\HttpResponses;
use App\AppServices\Service\IndexServices;
use App\AppServices\Category\GetCategories;
use App\AppServices\Unit\GetUnits;
use App\AppServices\Service\StoreService;
use App\AppServices\Service\UpdateService;

class ServiceController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of all services.
     * GET - връща view със таблица
     */
    public function index(ServiceFilter $filter)
    {
        $services = Service::filter($filter)
            ->with('category')
            ->latest()
            ->get();

        $categories = Category::get();

        return view('admin.services.index', compact('services', 'categories'));
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
            ->with('success', __('messages.service_created_successfully'));
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
            ->with('success', __('messages.service_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', __('messages.service_deleted_successfully'));
    }

    /**
     * Delete a specific image from a service
     */
    public function deleteImage(Service $service)
    {
        if ($service->hasMedia('service_thumbs')) {
            $service->clearMediaCollection('service_thumbs');
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
}
