<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Services\NotificationService;

class CommentController extends Controller
{
    public function store(CommentRequest $request, News $news)
    {
        Comment::create([
            'news_id' => $news->id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->body,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        NotificationService::newComment(
            $request->name,
            $news->title,
            route('admin.comments.index', ['status' => 'pending'])
        );

        return back()->with('success', 'আপনার মন্তব্যটি জমা হয়েছে। অনুমোদনের পর এটি প্রদর্শিত হবে। ধন্যবাদ!');
    }
}
