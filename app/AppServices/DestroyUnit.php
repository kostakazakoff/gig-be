<?php

namespace App\AppServices;

use App\Models\Units;
use Spatie\TranslationLoader\LanguageLine;

class DestroyUnit
{
    public function handle(Units $unit): void
    {
        // Delete translations for this unit
        LanguageLine::where('group', $unit->translation_group)
            ->where('key', $unit->translation_key . '.name')
            ->delete();

        $unit->delete();

        cache()->forget('spatie.translation-loader');
    }
}
