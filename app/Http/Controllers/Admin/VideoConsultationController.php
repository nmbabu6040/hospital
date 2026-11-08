<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoConsultation;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoConsultation::with(['doctor', 'patient']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $consultations = $query->latest()->paginate(20)->withQueryString();

        return view('admin.video-consultations.index', compact('consultations'));
    }

    public function edit(VideoConsultation $videoConsultation)
    {
        return view('admin.video-consultations.form', compact('videoConsultation'));
    }

    public function update(Request $request, VideoConsultation $videoConsultation)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,scheduled,completed,cancelled'],
            'scheduled_at' => ['nullable', 'date'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        // যখন প্রথমবার schedule করা হয়, একটা ইউনিক মিটিং রুম আইডি জেনারেট করো
        if ($data['status'] === 'scheduled' && ! $videoConsultation->meeting_room_id) {
            $data['meeting_room_id'] = 'HospitalConsult-' . Str::random(10);
        }

        $videoConsultation->update($data);

        return redirect()->route('admin.video-consultations.index')->with('success', 'Consultation updated. Patient will be notified.');
    }

    public function destroy(VideoConsultation $videoConsultation)
    {
        $videoConsultation->delete();

        return back()->with('success', 'Consultation request deleted.');
    }
}
