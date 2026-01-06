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
            'translation_group' => 'services',
            'translation_key' => $data['key'],
            'price_from' => $data['price_from'] ?? null,
            'price_to' => $data['price_to'] ?? null,
            'unit' => $data['unit'] ?? null,
        ]);

        LanguageLine::create([
            'group' => 'services',
            'key' => "{$data['key']}.name",
            'text' => [
                'en' => $data['name_en'],
                'bg' => $data['name_bg'],
            ],
        ]);

        LanguageLine::create([
            'group' => 'services',
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
