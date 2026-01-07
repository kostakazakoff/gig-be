<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Units::with('services')->latest()->get();
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
    public function store(StoreUnitsRequest $request)
    {
        $data = $request->validated();

        $unit = Units::create([
            'translation_group' => 'units'.'_'.$data['translation_key'],
            'translation_key' => $data['translation_key'],
        ]);

        LanguageLine::create([
            'group' => $unit->translation_group,
            'key' => "{$data['translation_key']}.name",
            'text' => [
                'en' => $data['name_en'],
                'bg' => $data['name_bg'],
            ],
        ]);

        cache()->forget('spatie.translation-loader');

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
    public function update(UpdateUnitsRequest $request, Units $unit)
    {
        $data = $request->validated();

        $currentKey = $unit->translation_key;
        $group = $unit->translation_group;

        // Update the unit record
        $unit->update([
            'translation_key' => $data['translation_key'],
        ]);

        // Find existing language line for name and update
        $line = LanguageLine::where([
            'group' => $group,
            'key' => "{$currentKey}.name",
        ])->first();

        if ($line) {
            // If key changed, update the key as well
            if ($currentKey !== $data['translation_key']) {
                $line->key = "{$data['translation_key']}.name";
            }
            $text = $line->text;
            $text['en'] = $data['name_en'];
            $text['bg'] = $data['name_bg'];
            $line->text = $text;
            $line->save();
        } else {
            // Create if missing
            LanguageLine::create([
                'group' => $group,
                'key' => "{$data['translation_key']}.name",
                'text' => [
                    'en' => $data['name_en'],
                    'bg' => $data['name_bg'],
                ],
            ]);
        }

        cache()->forget('spatie.translation-loader');

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Units $unit)
    {
        // Delete translations for this unit
        LanguageLine::where('group', $unit->translation_group)
            ->whereIn('key', [
                "{$unit->translation_key}.name",
            ])
            ->delete();

        $unit->delete();

        cache()->forget('spatie.translation-loader');

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}
