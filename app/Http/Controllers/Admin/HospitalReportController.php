<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalStat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HospitalReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'monthly'); // daily, weekly, monthly, yearly
        $hospitalId = $request->input('hospital_id');

        $admin = auth('admin')->user();
        $query = HospitalStat::forAdmin($admin);

        if ($hospitalId) {
            $query->where('hospital_id', $hospitalId);
        }

        [$startDate, $endDate, $groupFormat, $labelFormat] = $this->resolvePeriod($period);

        $query->whereBetween('stat_date', [$startDate, $endDate]);

        $rawStats = $query->get();

        // PHP দিয়ে group করা হচ্ছে (SQLite/MySQL উভয়ের সাথে কম্প্যাটিবল রাখতে)
        $grouped = $rawStats->groupBy(function ($stat) use ($groupFormat) {
            return $stat->stat_date->format($groupFormat);
        });

        $chartLabels = [];
        $admittedData = [];
        $testOnlyData = [];
        $opdData = [];
        $emergencyData = [];

        $cursor = $startDate->copy();
        $seenKeys = [];

        while ($cursor->lte($endDate)) {
            $key = $cursor->format($groupFormat);

            if (! in_array($key, $seenKeys)) {
                $seenKeys[] = $key;
                $groupItems = $grouped->get($key, collect());

                $chartLabels[] = $cursor->format($labelFormat);
                $admittedData[] = $groupItems->sum('patients_admitted');
                $testOnlyData[] = $groupItems->sum('test_only_patients');
                $opdData[] = $groupItems->sum('opd_patients');
                $emergencyData[] = $groupItems->sum('emergency_patients');
            }

            $cursor->addDay();
        }

        $summary = [
            'total_admitted' => $rawStats->sum('patients_admitted'),
            'total_discharged' => $rawStats->sum('patients_discharged'),
            'total_test_only' => $rawStats->sum('test_only_patients'),
            'total_opd' => $rawStats->sum('opd_patients'),
            'total_emergency' => $rawStats->sum('emergency_patients'),
        ];
        $summary['grand_total'] = $summary['total_admitted'] + $summary['total_test_only'] + $summary['total_opd'] + $summary['total_emergency'];

        $hospitals = Hospital::orderBy('name')->get();

        return view('admin.hospital-stats.reports', compact(
            'period',
            'hospitalId',
            'summary',
            'hospitals',
            'chartLabels',
            'admittedData',
            'testOnlyData',
            'opdData',
            'emergencyData',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Period অনুযায়ী start/end date এবং grouping format নির্ধারণ করে।
     */
    private function resolvePeriod(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'daily' => [$now->copy()->subDays(13), $now->copy(), 'Y-m-d', 'd M'],
            'weekly' => [$now->copy()->subWeeks(11)->startOfWeek(), $now->copy()->endOfWeek(), 'Y-W', 'W-\'y'],
            'yearly' => [$now->copy()->subYears(4)->startOfYear(), $now->copy()->endOfYear(), 'Y', 'Y'],
            default => [$now->copy()->subMonths(11)->startOfMonth(), $now->copy()->endOfMonth(), 'Y-m', 'M \'y'], // monthly (default)
        };
    }
}
