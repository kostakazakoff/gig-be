<?php

namespace App\Http\Controllers\Api;

use App\AppServices\ListCategories;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    use \App\Traits\HttpResponses;

    /**
     * Display a listing of all categories.
     * GET - за NEXT.js фронтенд (AJAX)
     */
    public function index(ListCategories $listCategories)
    {
        $categories = $listCategories->handle();
        
        return $this->success($categories);
    }

    /**
     * Display the specified category.
     * GET - за NEXT.js фронтенд (AJAX)
     */
    public function show(Category $category)
    {
        return $this->success([
            'id' => $category->id,
            'key' => $category->abreviation,
            'name' => $category->name,
            'description' => $category->description,
        ]);
    }
}
