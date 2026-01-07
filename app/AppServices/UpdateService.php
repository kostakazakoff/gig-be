<?php

namespace App\AppServices;

use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;

class UpdateService
{
    public function handle(Service $service, array $data): Service
    {
        // Update category and price data if provided
        $updateData = ['category_id' => $data['category_id'] ?? $service->category_id];
        
        if (isset($data['price_from'])) {
            $updateData['price_from'] = $data['price_from'];
        }
        if (isset($data['price_to'])) {
            $updateData['price_to'] = $data['price_to'];
        }
        if (isset($data['unit'])) {
            $updateData['unit'] = $data['unit'];
        }
        
        $service->update($updateData);

        $currentKey = $service->translation_key;

        // Update name translation
        $nameLine = LanguageLine::where([
            'group' => $service->translation_group,
            'key' => "{$currentKey}.name",
        ])->first();


        $text = $nameLine->text;
            $text['en'] = $data['name_en'];
            $text['bg'] = $data['name_bg'];
            $nameLine->update(['text' => $text]);

            
        // Update description translation
        $descriptionLine = LanguageLine::where([
            'group' => $service->translation_group,
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
