<?php

namespace App\AppServices;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class StoreCategory
{
    public function handle(array $data): Category
    {
        $category = Category::create([
            'translation_group' => 'categories'.'_'.$data['key'],
            'translation_key' => $data['key'],
        ]);

        LanguageLine::create([
            'group' => $category->translation_group,
            'key' => "{$data['key']}.name",
            'text' => [
                'en' => $data['name_en'],
                'bg' => $data['name_bg'],
            ],
        ]);

        LanguageLine::create([
            'group' => $category->translation_group,
            'key' => "{$data['key']}.description",
            'text' => [
                'en' => $data['description_en'],
                'bg' => $data['description_bg'],
            ],
        ]);

        cache()->forget('spatie.translation-loader');

        // Attach image if provided
        if ($data['image'] ?? null) {
            $category
                ->addMedia($data['image'])
                ->toMediaCollection('category_thumbs');
        }

        return $category;
    }
}
