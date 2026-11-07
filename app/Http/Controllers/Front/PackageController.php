<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('name')->get();

        return view('front.packages.index', compact('packages'));
    }

    public function show(Package $package)
    {
        $package->load('individualTests');

        return view('front.packages.show', compact('package'));
    }
}
