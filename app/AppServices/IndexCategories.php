<?php

namespace App\AppServices;

use App\Models\Category;

class IndexCategories
{
    public function handle()
    {
        return Category::all();
    }
}
