<?php

namespace App\AppServices\Category;

use App\Models\Category;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;

class StoreCategory
{
    use CreateThumbnail, Translates;

    public function handle(array $data): Category
    {
        $category = Category::create([
            'translation_group' => 'categories'.'_'.$data['key'],
            'translation_key' => $data['key'],
        ]);

        $this->translate($category, data: $data, attributes: ['name', 'description']);

        if ($data['image'] ?? null) {
            $this->createThumbnail($category, [$data['image']], 'category_thumbs');
        }

        return $category;
    }
}
