<?php

namespace App\AppServices\Category;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class DestroyCategory
{
    public function handle(Category $category): void
    {
        $category->delete();
    }
}
