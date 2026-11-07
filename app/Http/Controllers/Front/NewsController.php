<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::latest('published_at')->paginate(12);

        return view('front.news.index', compact('newsItems'));
    }

    public function show(News $news)
    {
        $related = News::where('id', '!=', $news->id)->latest('published_at')->take(3)->get();
        $comments = $news->approvedComments()->with('replies')->get();

        return view('front.news.show', compact('news', 'related', 'comments'));
    }
}
