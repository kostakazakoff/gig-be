<?php

namespace App\AppServices\Category;

use App\Models\Category;

class GetCategories
{
    public function handle()
    {
        return Category::all();
    }
}
