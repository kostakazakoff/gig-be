<?php

namespace App\AppServices;

use App\Models\Category;

class GetCategories
{
    public function handle()
    {
        return Category::all();
    }
}
