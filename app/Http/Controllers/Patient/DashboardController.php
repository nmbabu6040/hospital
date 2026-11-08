<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index()
    {
        $patient = auth('patient')->user();

        $appointments = $patient->appointments()->with('doctor')->latest()->take(5)->get();
        $reports = $patient->onlineReports()->latest()->take(5)->get();
        $invoices = $patient->invoices()->latest()->take(5)->get();
        $consultations = $patient->videoConsultations()->with('doctor')->latest()->take(5)->get();

        $counts = [
            'appointments' => $patient->appointments()->count(),
            'reports' => $patient->onlineReports()->count(),
            'invoices' => $patient->invoices()->count(),
        ];

        return view('patient.dashboard', compact('appointments', 'reports', 'invoices', 'consultations', 'counts'));
    }

    public function appointments()
    {
        $patient = auth('patient')->user();
        $appointments = $patient->appointments()->with('doctor')->latest()->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    public function reports()
    {
        $patient = auth('patient')->user();
        $reports = $patient->onlineReports()->latest()->paginate(10);

        return view('patient.reports', compact('reports'));
    }

    public function invoices()
    {
        $patient = auth('patient')->user();
        $invoices = $patient->invoices()->latest()->paginate(10);

        return view('patient.invoices', compact('invoices'));
    }

    public function profile()
    {
        $patient = auth('patient')->user();

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $patient = auth('patient')->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'address' => ['nullable', 'string', 'max:500'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($patient->avatar) {
                \Storage::disk('public')->delete($patient->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('patients', 'public');
        }

        $patient->update($data);

        return back()->with('success', 'প্রোফাইল আপডেট হয়েছে।');
    }

    public function updatePassword(Request $request)
    {
        $patient = auth('patient')->user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $patient->password)) {
            return back()->withErrors(['current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।']);
        }

        $patient->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'পাসওয়ার্ড পরিবর্তন হয়েছে।');
    }
}
