<?php

namespace App\Http\Controllers\Api;

use App\AppServices\ListCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class CategoryController extends Controller
{
    use \App\Traits\HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(ListCategories $listCategories)
    {
        $categories = $listCategories->handle();
        
        return $this->success($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'abreviation' => $request->key,
            'translation_group' => 'categories',
            'translation_key' => $request->key,
        ]);

        LanguageLine::create([
            'group' => 'categories',
            'key' => "{$request->key}.name",
            'text' => [
                'en' => $request->name_en,
                'bg' => $request->name_bg,
            ],
        ]);

        LanguageLine::create([
            'group' => 'categories',
            'key' => "{$request->key}.description",
            'text' => [
                'en' => $request->description_en,
                'bg' => $request->description_bg,
            ],
        ]);

        cache()->forget('spatie.translation-loader');

        return response()->json([$category, $category->name], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
