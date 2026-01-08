<?php

namespace App\AppServices\Category;

use App\Models\Category;
use App\Traits\OptimizesImages;
use Spatie\TranslationLoader\LanguageLine;

class StoreCategory
{
    use OptimizesImages;

    public function handle(array $data): Category
    {
        $category = Category::create([
            'translation_group' => 'categories'.'_'.$data['key'],
            'translation_key' => $data['key'],
        ]);

        //TODO: Refactor to a Translation Action or Service
        // ----------------------------------------------------
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
        // ----------------------------------------------------

        cache()->forget('spatie.translation-loader');

        // TODO: Refactor image optimization to a dedicated Action
        // Attach image if provided
        if ($data['image'] ?? null) {
            $this->optimizeImage($data['image'], 384, 256);

            $category
                ->addMedia($data['image'])
                ->toMediaCollection('category_thumbs');
        }

        return $category;
    }
}
