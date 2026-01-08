<?php

namespace App\AppServices\News;

use App\Models\News;

class IndexNews
{
    public function handle()
    {
        return News::all();
    }
}
