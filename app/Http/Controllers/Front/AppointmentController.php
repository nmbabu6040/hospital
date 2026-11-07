<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\NotificationService;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $selectedDoctor = request('doctor');

        return view('front.appointment.create', compact('doctors', 'selectedDoctor'));
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();
        $branchId = null;

        if (! empty($data['doctor_id'])) {
            $doctor = Doctor::find($data['doctor_id']);
            $branchId = $doctor?->branch_id;
            $data['branch_id'] = $branchId;
        }

        $appointment = Appointment::create($data);

        NotificationService::newAppointment(
            $appointment->name,
            $branchId,
            route('admin.appointments.index')
        );

        return back()->with('success', 'আপনার অ্যাপয়েন্টমেন্ট সফলভাবে জমা হয়েছে। আমরা শীঘ্রই যোগাযোগ করবো।');
    }
}
