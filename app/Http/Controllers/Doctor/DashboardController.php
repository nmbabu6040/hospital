<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = auth('doctor')->user();

        $todayAppointments = $doctor->appointments()->whereDate('date', now()->format('Y-m-d'))->where('status', '!=', 'Cancelled')->get();
        $upcomingAppointments = $doctor->appointments()->whereDate('date', '>', now()->format('Y-m-d'))->where('status', '!=', 'Cancelled')->orderBy('date')->take(10)->get();

        $counts = [
            'today' => $todayAppointments->count(),
            'total' => $doctor->appointments()->count(),
            'reviews' => $doctor->reviewCount(),
            'rating' => $doctor->averageRating(),
        ];

        return view('doctor.dashboard', compact('doctor', 'todayAppointments', 'upcomingAppointments', 'counts'));
    }

    public function appointments()
    {
        $doctor = auth('doctor')->user();
        $appointments = $doctor->appointments()->latest('date')->paginate(20);

        return view('doctor.appointments', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, \App\Models\Appointment $appointment)
    {
        abort_unless($appointment->doctor_id === auth('doctor')->id(), 403);

        $request->validate(['status' => ['required', 'in:Pending,Confirmed,Cancelled']]);
        $appointment->update(['status' => $request->status]);

        \App\Services\NotificationService::sendAppointmentStatusUpdateToPatient($appointment);

        return back()->with('success', 'Appointment status updated.');
    }

    public function schedule()
    {
        $doctor = auth('doctor')->user();
        $schedules = $doctor->schedules()->orderBy('day_of_week')->get();

        return view('doctor.schedule', compact('doctor', 'schedules'));
    }
}
