<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\HospitalStat;
use App\Models\Hospital;
use App\Models\Diagnostic;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'doctors' => Doctor::count(),
            'departments' => Department::count(),
            'appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'Pending')->count(),
            'messages' => ContactMessage::where('is_read', false)->count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'hospitals' => Hospital::count(),
            'diagnostics' => Diagnostic::count(),
        ];

        $recentAppointments = Appointment::with('doctor')->latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Appointment::whereDate('created_at', $date->format('Y-m-d'))->count();
        }

        $statusCounts = [
            'Pending' => Appointment::where('status', 'Pending')->count(),
            'Confirmed' => Appointment::where('status', 'Confirmed')->count(),
            'Cancelled' => Appointment::where('status', 'Cancelled')->count(),
        ];

        // আজকের ও এই মাসের patient stats সামারি
        $todayStats = HospitalStat::whereDate('stat_date', now()->format('Y-m-d'))->get();
        $monthStats = HospitalStat::whereYear('stat_date', now()->year)->whereMonth('stat_date', now()->month)->get();

        $patientSummary = [
            'today_admitted' => $todayStats->sum('patients_admitted'),
            'today_test_only' => $todayStats->sum('test_only_patients'),
            'month_admitted' => $monthStats->sum('patients_admitted'),
            'month_test_only' => $monthStats->sum('test_only_patients'),
        ];

        return view('admin.dashboard', compact(
            'counts',
            'recentAppointments',
            'recentMessages',
            'chartLabels',
            'chartData',
            'statusCounts',
            'patientSummary',

        ));
    }
}
