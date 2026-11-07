<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::latest()->paginate(24);

        return view('front.gallery.index', compact('images'));
    }
}
