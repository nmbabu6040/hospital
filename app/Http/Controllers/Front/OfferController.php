<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->paginate(12);

        return view('front.offers.index', compact('offers'));
    }
}
