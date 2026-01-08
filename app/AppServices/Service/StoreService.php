<?php

namespace App\AppServices\Service;

use App\Models\Service;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;
use Spatie\TranslationLoader\LanguageLine;

class StoreService
{
    use CreateThumbnail, Translates;

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

        $this->translate($service, data: $data, attributes: ['name', 'description']);

        // Attach image if provided
        if ($data['image'] ?? null) {
            $this->createThumbnail($service, [$data['image']], 'service_thumbs');
        }

        return $service;
    }
}
