<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function switch(string $locale)
    {
        if (in_array($locale, ['en', 'bn'])) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
