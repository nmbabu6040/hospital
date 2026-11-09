<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::where('is_active', true)->where('publish_date', '<=', now()->format('Y-m-d'));

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $notices = $query->latest('publish_date')->paginate(15)->withQueryString();

        return view('front.notices.index', compact('notices'));
    }

    public function show(Notice $notice)
    {
        abort_if(! $notice->is_active, 404);

        return view('front.notices.show', compact('notice'));
    }
}
