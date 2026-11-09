<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseItem;

class ShowcaseController extends Controller
{
    public function corporate()
    {
        $items = ShowcaseItem::ofType('corporate')->get();

        return view('front.pages.corporate', compact('items'));
    }

    public function awards()
    {
        $items = ShowcaseItem::ofType('award')->get();

        return view('front.pages.awards', compact('items'));
    }

    public function csr()
    {
        $items = ShowcaseItem::ofType('csr')->get();

        return view('front.pages.csr', compact('items'));
    }
}
