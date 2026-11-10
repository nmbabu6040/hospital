<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get()->groupBy(fn($faq) => $faq->category ?: 'General');

        return view('front.pages.faq', compact('faqs'));
    }
}
