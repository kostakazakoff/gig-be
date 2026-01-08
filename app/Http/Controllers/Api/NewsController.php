<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of all news articles.
     */
    public function index()
    {
        $news = News::all();
        return $this->success($news);
    }

    /**
     * Display the specified news article.
     */
    public function show($id)
    {
        $news = News::find($id);
        if (!$news) {
            return $this->error('News article not found', 404);
        }

        return $this->success($news);
    }
}
