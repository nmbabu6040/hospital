<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)->latest()->paginate(50);
        $totalActive = NewsletterSubscriber::where('is_active', true)->count();

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'totalActive'));
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)->pluck('email');

        $csv = "Email\n" . $subscribers->implode("\n");

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter-subscribers.csv"',
        ]);
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        return back()->with('success', 'Subscriber removed.');
    }
}
