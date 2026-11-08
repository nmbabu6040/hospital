<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\HospitalStat;
use App\Models\News;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'doctors' => Doctor::count(),
            'departments' => Department::count(),
            'hospitals' => Hospital::count(),
            'diagnostics' => Diagnostic::count(),
            'appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'Pending')->count(),
            'messages' => ContactMessage::where('is_read', false)->count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'packages' => Package::count(),
            'news' => News::count(),
        ];

        $recentAppointments = Appointment::with('doctor')->latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        // Appointment trend — শেষ ৭ দিন
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

        // Patient statistics সামারি
        $todayStats = HospitalStat::whereDate('stat_date', now()->format('Y-m-d'))->get();
        $monthStats = HospitalStat::whereYear('stat_date', now()->year)->whereMonth('stat_date', now()->month)->get();
        $patientSummary = [
            'today_admitted' => $todayStats->sum('patients_admitted'),
            'today_test_only' => $todayStats->sum('test_only_patients'),
            'month_admitted' => $monthStats->sum('patients_admitted'),
            'month_test_only' => $monthStats->sum('test_only_patients'),
        ];

        // Top ৫ ডাক্তার — সবচেয়ে বেশি appointment পাওয়া
        $topDoctors = Appointment::select('doctor_id', DB::raw('count(*) as total'))
            ->whereNotNull('doctor_id')
            ->groupBy('doctor_id')
            ->orderByDesc('total')
            ->with('doctor')
            ->take(5)
            ->get()
            ->filter(fn($item) => $item->doctor !== null);

        // Top ৫ Department — ডাক্তার সংখ্যা অনুযায়ী জনপ্রিয়তা (প্রক্সি মেট্রিক)
        $topDepartments = Department::withCount('doctors')
            ->orderByDesc('doctors_count')
            ->take(5)
            ->get();

        // শেষ ৬ মাসের monthly admitted vs test-only (bar+line combo chart)
        $monthlyLabels = [];
        $monthlyAdmitted = [];
        $monthlyTestOnly = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            $stats = HospitalStat::whereYear('stat_date', $month->year)->whereMonth('stat_date', $month->month)->get();
            $monthlyAdmitted[] = $stats->sum('patients_admitted');
            $monthlyTestOnly[] = $stats->sum('test_only_patients');
        }

        // System health / content summary (ছোট progress-style widget)
        $contentSummary = [
            'hospitals' => Hospital::where('is_active', true)->count(),
            'diagnostics' => Diagnostic::where('is_active', true)->count(),
            'packages' => Package::count(),
            'news' => News::count(),
        ];

        return view('admin.dashboard', compact(
            'counts',
            'recentAppointments',
            'recentMessages',
            'chartLabels',
            'chartData',
            'statusCounts',
            'patientSummary',
            'topDoctors',
            'topDepartments',
            'monthlyLabels',
            'monthlyAdmitted',
            'monthlyTestOnly',
            'contentSummary'
        ));
    }
}
