<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\QueueDisplay;

class QueueController extends Controller
{
    public function beds()
    {
        $hospitals = Hospital::with('bedCategories')->where('is_active', true)->get();

        return view('front.beds.index', compact('hospitals'));
    }

    public function queue()
    {
        $queues = QueueDisplay::where('is_active', true)
            ->whereDate('queue_date', now()->format('Y-m-d'))
            ->with('doctor')
            ->get();

        return view('front.queue.index', compact('queues'));
    }
}
