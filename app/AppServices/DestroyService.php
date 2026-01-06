<?php

namespace App\AppServices;

use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;

class DestroyService
{
    public function handle(Service $service): void
    {
        LanguageLine::where('group', 'services')
            ->whereIn('key', [
                "{$service->translation_key}.name",
                "{$service->translation_key}.description",
            ])
            ->delete();

        $service->delete();
        cache()->forget('spatie.translation-loader');
    }
}
