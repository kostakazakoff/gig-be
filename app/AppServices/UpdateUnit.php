<?php

namespace App\AppServices;

use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;

class UpdateUnit
{
    public function handle(Units $unit, array $data): Units
    {
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

        return $unit;
    }
}
