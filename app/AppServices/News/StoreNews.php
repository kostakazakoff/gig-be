<?php

namespace App\AppServices\News;

use App\Models\News;
use App\Traits\CreateThumbnail;
use App\Traits\Translates;

class StoreNews
{
    use CreateThumbnail, Translates;

    public function handle(array $data): News
    {
        $news = News::create([
            'translation_group' => 'news'.'_'.$data['key'],
            'translation_key' => $data['key'],
        ]);

        $this->translate($news, data: $data, attributes: ['title', 'content']);

        if ($data['image'] ?? null) {
            $this->createThumbnail($news, [$data['image']], 'news_thumbs');
        }

        return $news;
    }
}
