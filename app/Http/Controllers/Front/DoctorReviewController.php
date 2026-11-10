<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorReviewRequest;
use App\Models\Doctor;
use App\Models\DoctorReview;

class DoctorReviewController extends Controller
{
    public function store(DoctorReviewRequest $request, Doctor $doctor)
    {
        DoctorReview::create([
            'doctor_id' => $doctor->id,
            'patient_id' => auth('patient')->id(),
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'আপনার রিভিউ জমা হয়েছে। অনুমোদনের পর এটি প্রদর্শিত হবে। ধন্যবাদ!');
    }
}
