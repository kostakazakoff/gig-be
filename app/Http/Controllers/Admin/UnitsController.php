<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Units\StoreUnitsRequest;
use App\Http\Requests\Units\UpdateUnitsRequest;
use App\Models\Units;
use App\AppServices\Unit\IndexUnits;
use App\AppServices\Unit\StoreUnit;
use App\AppServices\Unit\UpdateUnit;
use App\AppServices\Unit\DestroyUnit;
use App\Traits\HttpResponses;

class UnitsController extends Controller
{
    use HttpResponses;
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
            ->with('success', __('messages.unit_created_successfully'));
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
            ->with('success', __('messages.unit_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Units $unit)
    {
        if ($unit->services()->exists()) {
            return back()->withErrors([
                'delete' => __('messages.unit_in_use_cannot_be_deleted'),
            ]);
        }

        $unit->delete();

        return redirect()
            ->route('admin.units.index')
            ->with('success', __('messages.unit_deleted_successfully'));
    }
}
