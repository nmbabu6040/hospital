<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use App\Models\Hospital;

class LocationController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::where('is_active', true)->whereNotNull('latitude')->get();
        $diagnostics = Diagnostic::where('is_active', true)->whereNotNull('latitude')->get();

        return view('front.locations.index', compact('hospitals', 'diagnostics'));
    }
}
