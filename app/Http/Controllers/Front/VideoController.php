<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(12);

        return view('front.videos.index', compact('videos'));
    }
}
