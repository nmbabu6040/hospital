<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoConsultationRequest;
use App\Models\Doctor;
use App\Models\VideoConsultation;
use App\Services\NotificationService;

class VideoConsultationController extends Controller
{
    public function create()
    {
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $selectedDoctor = request('doctor');
        $patient = auth('patient')->user();

        return view('front.telemedicine.create', compact('doctors', 'selectedDoctor', 'patient'));
    }

    public function store(VideoConsultationRequest $request)
    {
        $data = $request->validated();

        if (auth('patient')->check()) {
            $data['patient_id'] = auth('patient')->id();
        }

        $consultation = VideoConsultation::create($data);

        NotificationService::newAppointment(
            $consultation->patient_name . ' (Video Consultation)',
            null,
            route('admin.video-consultations.index')
        );

        return back()->with('success', 'আপনার ভিডিও কনসালটেশন রিকোয়েস্ট জমা হয়েছে। অনুমোদনের পর আমরা আপনাকে মিটিং সময় ও লিংক জানিয়ে দেবো।');
    }

    public function joinRoom(VideoConsultation $videoConsultation)
    {
        abort_unless($videoConsultation->isJoinable(), 403, 'এই মুহূর্তে এই মিটিং রুমে প্রবেশ করা যাবে না। নির্ধারিত সময়ের ১৫ মিনিট আগে আবার চেষ্টা করুন।');

        return view('front.telemedicine.room', compact('videoConsultation'));
    }
}
