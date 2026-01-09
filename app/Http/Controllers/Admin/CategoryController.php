<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\HttpResponses;
use App\AppServices\Category\IndexCategories;
use App\AppServices\Category\StoreCategory;
use App\AppServices\Category\UpdateCategory;
use App\AppServices\Category\DestroyCategory;

class CategoryController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of all categories.
     * GET - връща view със таблица
     */
    public function index(IndexCategories $indexCategories)
    {
        $categories = $indexCategories->handle();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * GET - връща view с форма
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST - обработка от Blade форма
     */
    public function store(StoreCategoryRequest $request, StoreCategory $service)
    {
        $service->handle($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     * GET - връща view с форма
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH - обработка от Blade форма
     */
    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategory $service)
    {
        $service->handle($category, $request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(Category $category, DestroyCategory $service)
    {
        $service->handle($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }

    /**
     * Delete a specific image from a category
     */
    public function deleteImage(Category $category)
    {
        if ($category->hasMedia('category_thumbs')) {
            $category->clearMediaCollection('category_thumbs');
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
}
