<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\News;
use App\Models\Package;
use App\Models\Page;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect();

        $urls->push(['loc' => route('home'), 'priority' => '1.0']);
        $urls->push(['loc' => route('doctors.index'), 'priority' => '0.8']);
        $urls->push(['loc' => route('departments.index'), 'priority' => '0.8']);
        $urls->push(['loc' => route('hospitals.index'), 'priority' => '0.8']);
        $urls->push(['loc' => route('packages.index'), 'priority' => '0.8']);
        $urls->push(['loc' => route('news.index'), 'priority' => '0.7']);
        $urls->push(['loc' => route('contact.index'), 'priority' => '0.6']);

        foreach (Doctor::where('is_active', true)->get() as $doctor) {
            $urls->push(['loc' => route('doctors.show', $doctor), 'priority' => '0.6']);
        }

        foreach (Department::all() as $department) {
            $urls->push(['loc' => route('departments.show', $department), 'priority' => '0.6']);
        }

        foreach (Hospital::where('is_active', true)->get() as $hospital) {
            $urls->push(['loc' => route('hospitals.show', $hospital), 'priority' => '0.6']);
        }

        foreach (Package::all() as $package) {
            $urls->push(['loc' => route('packages.show', $package), 'priority' => '0.5']);
        }

        foreach (News::all() as $news) {
            $urls->push(['loc' => route('news.show', $news), 'priority' => '0.5']);
        }

        foreach (Page::where('is_active', true)->get() as $page) {
            $urls->push(['loc' => route('pages.show', $page), 'priority' => '0.4']);
        }

        $xml = view('sitemap', compact('urls'))->render();

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
