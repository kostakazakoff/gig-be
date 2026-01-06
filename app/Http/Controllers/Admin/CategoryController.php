<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class CategoryController extends Controller
{
    use \App\Traits\HttpResponses;

    /**
     * Display a listing of all categories.
     * GET - връща view със таблица
     */
    public function index()
    {
        $categories = Category::all();
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
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create([
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

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update([
                'translation_key' => $request->key,
            ]);

            // Обновяване на превод за име
            LanguageLine::updateOrCreate(
                [
                    'group' => 'categories',
                    'key' => "{$request->key}.name",
                ],
                [
                    'text' => [
                        'en' => $request->name_en,
                        'bg' => $request->name_bg,
                    ],
                ]
            );

            // Обновяване на превод за описание
            LanguageLine::updateOrCreate(
                [
                    'group' => 'categories',
                    'key' => "{$request->key}.description",
                ],
                [
                    'text' => [
                        'en' => $request->description_en,
                        'bg' => $request->description_bg,
                    ],
                ]
            );

            cache()->forget('spatie.translation-loader');

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            cache()->forget('spatie.translation-loader');

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
