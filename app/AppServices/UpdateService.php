<?php

namespace App\AppServices;

use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;

class UpdateService
{
    public function handle(Service $service, array $data): Service
    {
        // Update category if provided
        if (isset($data['category_id'])) {
            $service->update(['category_id' => $data['category_id']]);
        }

        $currentKey = $service->translation_key;

        // Update name translation
        $nameLine = LanguageLine::where([
            'group' => 'services',
            'key' => "{$currentKey}.name",
        ])->first();

        $text = $nameLine->text;
        $text['en'] = $data['name_en'];
        $text['bg'] = $data['name_bg'];
        $nameLine->update(['text' => $text]);

        // Update description translation
        $descriptionLine = LanguageLine::where([
            'group' => 'services',
            'key' => "{$currentKey}.description",
        ])->first();

        $text = $descriptionLine->text;
        $text['en'] = $data['description_en'];
        $text['bg'] = $data['description_bg'];
        $descriptionLine->update(['text' => $text]);

        cache()->forget('spatie.translation-loader');

        // Update image if provided
        if ($data['image'] ?? null) {
            $service
                ->addMedia($data['image'])
                ->toMediaCollection('service_thumbs');
        }

        return $service;
    }
}
