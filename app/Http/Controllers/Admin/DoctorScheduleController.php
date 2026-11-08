<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorLeave;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index(Doctor $doctor)
    {
        $schedules = $doctor->schedules()->orderBy('day_of_week')->get();
        $leaves = $doctor->leaves()->orderBy('leave_date')->get();

        return view('admin.doctor-schedules.index', compact('doctor', 'schedules', 'leaves'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'day_of_week' => ['required', 'integer', 'between:0,6'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'slot_duration_minutes' => ['required', 'integer', 'min:5', 'max:120'],
            'max_patients_per_slot' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $data['is_active'] = true;
        $doctor->schedules()->create($data);

        return back()->with('success', 'Schedule added successfully.');
    }

    public function destroy(Doctor $doctor, DoctorSchedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Schedule removed successfully.');
    }

    public function toggleActive(Doctor $doctor, DoctorSchedule $schedule)
    {
        $schedule->update(['is_active' => ! $schedule->is_active]);

        return back()->with('success', 'Schedule status updated.');
    }

    public function storeLeave(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'leave_date' => ['required', 'date', 'after_or_equal:today'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $doctor->leaves()->updateOrCreate(['leave_date' => $data['leave_date']], $data);

        return back()->with('success', 'Leave day added successfully.');
    }

    public function destroyLeave(Doctor $doctor, DoctorLeave $leave)
    {
        $leave->delete();

        return back()->with('success', 'Leave day removed.');
    }
}
