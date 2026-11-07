<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['news', 'parent']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $comments = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'rejected' => Comment::where('status', 'rejected')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'counts'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Comment approved.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Comment rejected.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }

    /**
     * Admin সরাসরি কোনো কমেন্টের জবাব দিচ্ছে — এই রিপ্লাই অটো-approved থাকবে,
     * কারণ এটা নিজেরাই পোস্ট করছে, মডারেশনের দরকার নেই।
     */
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        $admin = auth('admin')->user();

        Comment::create([
            'news_id' => $comment->news_id,
            'parent_id' => $comment->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'body' => $request->body,
            'status' => 'approved',
            'is_admin_reply' => true,
            'admin_id' => $admin->id,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }
}
