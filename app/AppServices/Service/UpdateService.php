<?php

namespace App\AppServices\Service;

use App\Models\Service;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;
use Spatie\TranslationLoader\LanguageLine;

class UpdateService
{
    use CreateThumbnail, Translates;

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
        if (array_key_exists('unit_id', $data)) {
            $updateData['unit_id'] = $data['unit_id'];
        }
        
        $service->update($updateData);

        $this->updateTranslation($service, $data, ['name', 'description']);

        // Update image if provided
        if ($data['image'] ?? null) {
            $this->createThumbnail($service, [$data['image']], 'service_thumbs');
        }

        return $service;
    }
}
