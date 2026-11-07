<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();

        return view('front.hospitals.index', compact('hospitals'));
    }

    public function show(Hospital $hospital)
    {
        $doctors = $hospital->doctors()->where('is_active', true)->get();

        return view('front.hospitals.show', compact('hospital', 'doctors'));
    }
}
