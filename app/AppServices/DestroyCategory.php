<?php

namespace App\AppServices;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class DestroyCategory
{
    public function handle(Category $category): void
    {
        LanguageLine::where('group', 'categories')
            ->whereIn('key', [
                "{$category->translation_key}.name",
                "{$category->translation_key}.description",
            ])
            ->delete();

        $category->delete();
        cache()->forget('spatie.translation-loader');
    }
}
