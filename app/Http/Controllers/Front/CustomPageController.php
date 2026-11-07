<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;

class CustomPageController extends Controller
{
    public function show(Page $page)
    {
        abort_if(! $page->is_active, 404);

        return view('front.pages.custom', compact('page'));
    }
}
