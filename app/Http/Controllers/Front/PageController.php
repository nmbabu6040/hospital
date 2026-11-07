<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\Accreditation;
use App\Models\SisterConcern;

class PageController extends Controller
{
    public function mdMessage()
    {
        $aboutContent = AboutContent::get();

        return view('front.pages.md-message', compact('aboutContent'));
    }

    public function about()
    {
        $aboutContent = AboutContent::get();

        return view('front.pages.about', compact('aboutContent'));
    }

    public function accreditation()
    {
        $accreditations = Accreditation::orderBy('sort_order')->get();

        return view('front.pages.accreditation', compact('accreditations'));
    }

    public function sisterConcerns()
    {
        $sisterConcerns = SisterConcern::all();

        return view('front.pages.sister-concerns', compact('sisterConcerns'));
    }
}
