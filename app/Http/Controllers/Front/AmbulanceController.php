<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AmbulanceRequest;
use App\Models\Setting;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    public function create()
    {
        $patient = auth('patient')->user();
        $setting = Setting::get();

        return view('front.ambulance.create', compact('patient', 'setting'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'requester_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'pickup_location' => ['required', 'string', 'max:500'],
            'drop_location' => ['nullable', 'string', 'max:500'],
            'ambulance_type' => ['required', 'in:Basic,ICU,Freezer'],
            'is_emergency' => ['nullable', 'boolean'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['is_emergency'] = $request->boolean('is_emergency');

        if (auth('patient')->check()) {
            $data['patient_id'] = auth('patient')->id();
        }

        $ambulanceRequest = AmbulanceRequest::create($data);

        NotificationService::newAppointment(
            $ambulanceRequest->requester_name . ($ambulanceRequest->is_emergency ? ' (🚨 EMERGENCY AMBULANCE)' : ' (Ambulance Request)'),
            null,
            route('admin.ambulance-requests.index')
        );

        return back()->with('success', 'আপনার অ্যাম্বুলেন্স রিকোয়েস্ট জমা হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করবো। জরুরি প্রয়োজনে সরাসরি হটলাইনে কল করুন।');
    }
}
