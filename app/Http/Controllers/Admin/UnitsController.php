<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Models\Units;
use App\AppServices\IndexUnits;
use App\AppServices\StoreUnit;
use App\AppServices\UpdateUnit;
use App\AppServices\DestroyUnit;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexUnits $indexUnits)
    {
        $units = $indexUnits->handle();
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitsRequest $request, StoreUnit $storeUnit)
    {
        $storeUnit->handle($request->validated());

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Units $unit)
    {
        return redirect()->route('admin.units.edit', $unit);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Units $unit)
    {
        return view('admin.units.edit', [
            'unit' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitsRequest $request, Units $unit, UpdateUnit $updateUnit)
    {
        $updateUnit->handle($unit, $request->validated());

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Units $unit, DestroyUnit $destroyUnit)
    {
        $destroyUnit->handle($unit);

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}
