<?php

namespace App\AppServices\Category;

use App\Models\Category;

class IndexCategories
{
    public function handle()
    {
        return Category::all();
    }
}
