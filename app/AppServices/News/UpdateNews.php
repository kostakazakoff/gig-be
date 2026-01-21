<?php

namespace App\AppServices\News;

use App\Models\News;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;

class UpdateNews
{
    use CreateThumbnail, Translates;

    public function handle(News $news, array $data): News
    {
        $this->updateTranslation($news, $data, ['title', 'content']);

        // Update image if provided
        if ($data['image'] ?? null) {
            $this->createThumbnail($news, [$data['image']], 'news_thumbs');
        }

        $news->save();

        return $news;
    }
}
