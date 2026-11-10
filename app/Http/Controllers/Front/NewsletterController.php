<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        return back()->with('success', 'নিউজলেটার সাবস্ক্রিপশন সফল হয়েছে। ধন্যবাদ!');
    }

    public function unsubscribe(Request $request)
    {
        NewsletterSubscriber::where('email', $request->email)->update(['is_active' => false]);

        return back()->with('success', 'আপনি নিউজলেটার থেকে আনসাবস্ক্রাইব করেছেন।');
    }
}
