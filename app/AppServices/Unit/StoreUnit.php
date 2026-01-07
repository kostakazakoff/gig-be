<?php

namespace App\AppServices\Unit;

use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;

class StoreUnit
{
    public function handle(array $data): Units
    {
        $unit = Units::create([
            'translation_group' => 'units_' . $data['translation_key'],
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

        return $unit;
    }
}
