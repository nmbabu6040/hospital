<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Journal;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::latest()->paginate(12);

        return view('front.journals.index', compact('journals'));
    }
}
