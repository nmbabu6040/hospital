<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OnlineReportController extends Controller
{
    public function index()
    {
        $reports = OnlineReport::latest()->paginate(20);

        return view('admin.online-reports.index', compact('reports'));
    }

    public function create()
    {
        $report = new OnlineReport();

        return view('admin.online-reports.form', compact('report'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['report_id'] = $data['report_id'] ?: 'RPT-' . strtoupper(Str::random(8));

        if ($request->hasFile('report_file')) {
            $data['report_file'] = $request->file('report_file')->store('reports', 'public');
            $data['status'] = 'ready';
        }

        OnlineReport::create($data);

        return redirect()->route('admin.online-reports.index')->with('success', 'Report entry added successfully.');
    }

    public function edit(OnlineReport $onlineReport)
    {
        return view('admin.online-reports.form', ['report' => $onlineReport]);
    }

    public function update(Request $request, OnlineReport $onlineReport)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('report_file')) {
            if ($onlineReport->report_file) {
                Storage::disk('public')->delete($onlineReport->report_file);
            }
            $data['report_file'] = $request->file('report_file')->store('reports', 'public');
            $data['status'] = 'ready';
        }

        $onlineReport->update($data);

        return redirect()->route('admin.online-reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(OnlineReport $onlineReport)
    {
        if ($onlineReport->report_file) {
            Storage::disk('public')->delete($onlineReport->report_file);
        }
        $onlineReport->delete();

        return back()->with('success', 'Report deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_id' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'report_id' => ['nullable', 'string', 'max:100', 'unique:online_reports,report_id' . ($request->route('online_report') ? ',' . $request->route('online_report')->id : '')],
            'report_date' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,ready'],
            'report_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);
    }
}
