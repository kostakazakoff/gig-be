<?php
namespace App\AppServices;

use App\Models\Category;


class ListCategories
{
public function handle()
    {
        $categories = Category::all();

        return $categories;
    }
}