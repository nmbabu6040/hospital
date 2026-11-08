<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\NotificationService;
use App\Services\SlotService;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $selectedDoctor = request('doctor');
        $patient = auth('patient')->user();

        $doctorScheduleData = [];

        foreach ($doctors as $doctor) {
            $dates = SlotService::availableDatesFor($doctor);

            $dateList = [];
            $slotsByDate = [];

            foreach ($dates as $date) {
                $dateList[] = [
                    'date' => $date,
                    'label' => Carbon::parse($date)->format('d M (D)'),
                ];
                $slotsByDate[$date] = SlotService::generateSlotsFor($doctor, $date);
            }

            $doctorScheduleData[$doctor->id] = [
                'hasSchedule' => count($dateList) > 0,
                'dates' => $dateList,
                'slotsByDate' => $slotsByDate,
            ];
        }

        return view('front.appointment.create', compact('doctors', 'selectedDoctor', 'patient', 'doctorScheduleData'));
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();
        $branchId = null;

        if (! empty($data['doctor_id'])) {
            $doctor = Doctor::find($data['doctor_id']);
            $branchId = $doctor?->branch_id;
            $data['branch_id'] = $branchId;

            if ($doctor && ! empty($data['slot_time'])) {
                $data['serial_no'] = SlotService::nextSerialNo($doctor, $data['date']);
            }
        }

        if (auth('patient')->check()) {
            $data['patient_id'] = auth('patient')->id();
        }

        $appointment = Appointment::create($data);

        NotificationService::sendAppointmentConfirmationToPatient($appointment);

        NotificationService::newAppointment(
            $appointment->name,
            $branchId,
            route('admin.appointments.index')
        );

        return back()->with('success', 'আপনার অ্যাপয়েন্টমেন্ট সফলভাবে জমা হয়েছে। ' . ($appointment->serial_no ? 'আপনার সিরিয়াল নম্বর: ' . $appointment->serial_no . '। ' : '') . 'আমরা শীঘ্রই যোগাযোগ করবো।');
    }
}
