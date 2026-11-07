<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Services\NotificationService;

class ContactController extends Controller
{
    public function index()
    {
        $setting = Setting::get();

        return view('front.contact.index', compact('setting'));
    }

    public function store(ContactRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        NotificationService::newMessage(
            $message->name,
            route('admin.messages.index')
        );

        return back()->with('success', 'আপনার বার্তা পাঠানো হয়েছে। আমরা শীঘ্রই যোগাযোগ করবো।');
    }
}
