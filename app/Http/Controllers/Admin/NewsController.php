<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Models\News;
use App\Traits\HttpResponses;
use App\AppServices\News\IndexNews;
use App\AppServices\News\StoreNews;
use App\AppServices\News\UpdateNews;
use App\AppServices\News\DestroyNews;

class NewsController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of all news articles.
     * GET - връща view със таблица
     */
    public function index(IndexNews $indexNews)
    {
        $news = $indexNews->handle()->sortByDesc('created_at');
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     * GET - връща view с форма
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST - обработка от Blade форма
     */
    public function store(StoreNewsRequest $request, StoreNews $service)
    {
        $service->handle($request->all());

        return redirect()->route('admin.news.index')
            ->with('success', __('messages.news_created_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET - връща view с форма
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH - обработка от Blade форма
     */
    public function update(UpdateNewsRequest $request, News $news, UpdateNews $service)
    {
        $service->handle($news, $request->all());

        return redirect()->route('admin.news.index')
            ->with('success', __('messages.news_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE - обработка от Blade форма
     */
    public function destroy(News $news, DestroyNews $service)
    {
        $service->handle($news);

        return redirect()->route('admin.news.index')
            ->with('success', __('messages.news_deleted_successfully'));
    }

    /**
     * Delete media file from news.
     * DELETE - AJAX request
     */
    public function deleteMedia(News $news, $media)
    {
        try {
            $mediaItem = $news->media()->where('id', $media)->firstOrFail();
            $mediaItem->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting media'], 500);
        }
    }
}

