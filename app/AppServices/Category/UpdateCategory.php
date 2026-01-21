<?php

namespace App\AppServices\Category;

use App\Models\Category;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;
use Spatie\TranslationLoader\LanguageLine;

class UpdateCategory
{
    use CreateThumbnail, Translates;
    public function handle(Category $category, array $data): Category
    {
        $this->updateTranslation($category, $data, ['name', 'description']);

        // Update image if provided
        if ($data['image'] ?? null) {
            $this->createThumbnail($category, [$data['image']], 'category_thumbs');
        }

        $category->save();

        return $category;
    }
}
