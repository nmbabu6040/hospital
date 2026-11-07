<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Hospital;
use App\Models\HospitalStat;
use Illuminate\Http\Request;

class HospitalStatController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth('admin')->user();
        $query = HospitalStat::with(['hospital', 'branch', 'createdBy'])->forAdmin($admin);

        if ($request->filled('from')) {
            $query->whereDate('stat_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('stat_date', '<=', $request->to);
        }
        if ($request->filled('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        $stats = $query->latest('stat_date')->paginate(20)->withQueryString();
        $hospitals = Hospital::orderBy('name')->get();

        return view('admin.hospital-stats.index', compact('stats', 'hospitals'));
    }

    public function create()
    {
        $hospitalStat = new HospitalStat();
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.hospital-stats.form', compact('hospitalStat', 'hospitals', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = auth('admin')->id();

        $admin = auth('admin')->user();
        if ($admin->isBranchAdmin() && $admin->branch_id) {
            $data['branch_id'] = $admin->branch_id;
        }

        HospitalStat::create($data);

        return redirect()->route('admin.hospital-stats.index')->with('success', 'Statistics entry added successfully.');
    }

    public function edit(HospitalStat $hospitalStat)
    {
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.hospital-stats.form', compact('hospitalStat', 'hospitals', 'branches'));
    }

    public function update(Request $request, HospitalStat $hospitalStat)
    {
        $data = $this->validateData($request);
        $hospitalStat->update($data);

        return redirect()->route('admin.hospital-stats.index')->with('success', 'Statistics entry updated successfully.');
    }

    public function destroy(HospitalStat $hospitalStat)
    {
        $hospitalStat->delete();

        return back()->with('success', 'Statistics entry deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'stat_date' => ['required', 'date'],
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'patients_admitted' => ['required', 'integer', 'min:0'],
            'patients_discharged' => ['required', 'integer', 'min:0'],
            'test_only_patients' => ['required', 'integer', 'min:0'],
            'opd_patients' => ['required', 'integer', 'min:0'],
            'emergency_patients' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
