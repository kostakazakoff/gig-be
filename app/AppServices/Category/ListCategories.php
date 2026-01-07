<?php
namespace App\AppServices\Category;

use App\Models\Category;


class ListCategories
{
public function handle()
    {
        $categories = Category::all();

        return $categories;
    }
}