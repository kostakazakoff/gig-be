<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Category;
use App\Traits\HttpResponses;
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
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * GET - връща view с форма
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * POST - обработка от Blade форма
     */
    public function store(StoreServiceRequest $request, StoreService $service)
    {
        $service->handle([
            'category_id' => $request->category_id,
            'key' => $request->key,
            'name_en' => $request->name_en,
            'name_bg' => $request->name_bg,
            'description_en' => $request->description_en,
            'description_bg' => $request->description_bg,
            'price_from' => $request->price_from,
            'price_to' => $request->price_to,
            'unit' => $request->unit,
            'image' => $request->file('image'),
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     * GET - връща view с форма
     */
    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH - обработка от Blade форма
     */
    public function update(UpdateServiceRequest $request, Service $service, UpdateService $updateService)
    {
        $updateService->handle($service, [
            'category_id' => $request->category_id,
            'name_en' => $request->name_en,
            'name_bg' => $request->name_bg,
            'description_en' => $request->description_en,
            'description_bg' => $request->description_bg,
            'price_from' => $request->price_from,
            'price_to' => $request->price_to,
            'unit' => $request->unit,
            'image' => $request->file('image'),
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(Service $service, DestroyService $destroyService)
    {
        $destroyService->handle($service);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }
}
