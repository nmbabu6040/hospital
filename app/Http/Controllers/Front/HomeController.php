<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\Accreditation;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\News;
use App\Models\SisterConcern;
use App\Models\Slider;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        $hospitals = Hospital::where('is_active', true)->get();
        $diagnostics = Diagnostic::where('is_active', true)->get();
        $departments = Department::where('is_featured', true)->orderBy('sort_order')->take(8)->get();
        $doctors = Doctor::where('is_active', true)->latest()->take(10)->get();
        $news = News::latest('published_at')->take(4)->get();
        $sisterConcerns = SisterConcern::latest('created_at')->take(5)->get();
        $accreditations = Accreditation::orderBy('sort_order')->get();
        $aboutContent = AboutContent::get();
        $featuredVideo = Video::where('is_featured', true)->first() ?? Video::latest()->first();

        return view('front.home', compact(
            'sliders',
            'hospitals',
            'diagnostics',
            'departments',
            'doctors',
            'news',
            'sisterConcerns',
            'accreditations',
            'aboutContent',
            'featuredVideo'
        ));
    }
}
