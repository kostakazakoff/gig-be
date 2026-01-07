<?php

namespace App\Observers;

use Spatie\TranslationLoader\LanguageLine;

class UnitObserver
{
    public function deleting($unit): void
    {
        LanguageLine::where('group', $unit->translation_group)
            ->where('key', $unit->translation_key . '.name')
            ->delete();

        cache()->forget('spatie.translation-loader');
    }
}
