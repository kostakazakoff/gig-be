<?php

namespace App\AppServices\News;

use App\Models\News;

class DestroyNews
{
    public function handle(News $news): void
    {
        $news->delete();
    }
}
