<?php

namespace App\AppServices\Category;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class UpdateCategory
{
    public function handle(Category $category, array $data): Category
    {
        $currentKey = $category->translation_key;

        // Update name translation
        $nameLine = LanguageLine::where([
            'group' => $category->translation_group,
            'key' => "{$currentKey}.name",
        ])->first();


        $text = $nameLine->text;
            $text['en'] = $data['name_en'];
            $text['bg'] = $data['name_bg'];
            $nameLine->update(['text' => $text]);

            
        // Update description translation
        $descriptionLine = LanguageLine::where([
            'group' => $category->translation_group,
            'key' => "{$currentKey}.description",
        ])->first();


        $text = $descriptionLine->text;
            $text['en'] = $data['description_en'];
            $text['bg'] = $data['description_bg'];
            $descriptionLine->update(['text' => $text]);

            
        cache()->forget('spatie.translation-loader');

        // Update image if provided
        if ($data['image'] ?? null) {
            $category
                ->addMedia($data['image'])
                ->toMediaCollection('category_thumbs');
        }

        return $category;
    }
}
