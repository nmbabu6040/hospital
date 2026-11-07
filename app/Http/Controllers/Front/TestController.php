<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Test::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tests = $query->orderBy('name')->paginate(30)->withQueryString();

        return view('front.tests.index', compact('tests'));
    }

    public function show(Test $test)
    {
        $relatedPackages = $test->packages()->get();

        return view('front.tests.show', compact('test', 'relatedPackages'));
    }
}
