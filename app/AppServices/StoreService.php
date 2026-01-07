<?php

namespace App\AppServices;

use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;

class StoreService
{
    public function handle(array $data): Service
    {
        $service = Service::create([
            'category_id' => $data['category_id'],
            'translation_group' => 'services'.'_'.$data['key'],
            'translation_key' => $data['key'],
            'price_from' => $data['price_from'] ?? null,
            'price_to' => $data['price_to'] ?? null,
            'unit_id' => $data['unit_id'] ?? null,
        ]);

        LanguageLine::create([
            'group' => $service->translation_group,
            'key' => "{$data['key']}.name",
            'text' => [
                'en' => $data['name_en'],
                'bg' => $data['name_bg'],
            ],
        ]);

        LanguageLine::create([
            'group' => $service->translation_group,
            'key' => "{$data['key']}.description",
            'text' => [
                'en' => $data['description_en'],
                'bg' => $data['description_bg'],
            ],
        ]);

        cache()->forget('spatie.translation-loader');

        // Attach image if provided
        if ($data['image'] ?? null) {
            $service
                ->addMedia($data['image'])
                ->toMediaCollection('service_thumbs');
        }

        return $service;
    }
}
