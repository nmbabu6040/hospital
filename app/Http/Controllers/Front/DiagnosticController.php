<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;

class DiagnosticController extends Controller
{
    public function index()
    {
        $diagnostics = Diagnostic::where('is_active', true)->orderBy('name')->get();

        return view('front.diagnostics.index', compact('diagnostics'));
    }

    public function show(Diagnostic $diagnostic)
    {
        return view('front.diagnostics.show', compact('diagnostic'));
    }
}
