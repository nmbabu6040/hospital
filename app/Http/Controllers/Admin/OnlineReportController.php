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

        $report = OnlineReport::create($data);

        $this->saveItems($request, $report);

        if ($report->hasGeneratedReport() && ! $request->hasFile('report_file')) {
            $report->update(['status' => 'ready']);
        }

        if ($report->status === 'ready') {
            \App\Services\NotificationService::sendReportReadyToPatient($report);
        }

        return redirect()->route('admin.online-reports.index')->with('success', 'Report entry added successfully.');
    }

    public function edit(OnlineReport $onlineReport)
    {
        $onlineReport->load('items');

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

        $onlineReport->items()->delete();
        $this->saveItems($request, $onlineReport);

        if ($onlineReport->hasGeneratedReport() && ! $request->hasFile('report_file')) {
            $onlineReport->update(['status' => 'ready']);
        }

        if ($onlineReport->status === 'ready') {
            \App\Services\NotificationService::sendReportReadyToPatient($onlineReport);
        }

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

    private function saveItems(Request $request, OnlineReport $report): void
    {
        $testNames = $request->input('test_name', []);
        $resultValues = $request->input('result_value', []);
        $units = $request->input('unit', []);
        $normalRanges = $request->input('normal_range', []);
        $abnormalFlags = $request->input('is_abnormal', []);

        foreach ($testNames as $index => $name) {
            if (trim($name) === '') {
                continue;
            }

            $report->items()->create([
                'test_name' => $name,
                'result_value' => $resultValues[$index] ?? null,
                'unit' => $units[$index] ?? null,
                'normal_range' => $normalRanges[$index] ?? null,
                'is_abnormal' => isset($abnormalFlags[$index]),
                'sort_order' => $index,
            ]);
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_ref_id' => ['nullable', 'string', 'max:100'],
            'referred_by' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'phone' => ['required', 'string', 'max:50'],
            'report_id' => ['nullable', 'string', 'max:100', 'unique:online_reports,report_id' . ($request->route('online_report') ? ',' . $request->route('online_report')->id : '')],
            'report_date' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,ready'],
            'report_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'verified_by' => ['nullable', 'string', 'max:255'],
            'test_name.*' => ['nullable', 'string', 'max:255'],
            'result_value.*' => ['nullable', 'string', 'max:100'],
            'unit.*' => ['nullable', 'string', 'max:50'],
            'normal_range.*' => ['nullable', 'string', 'max:100'],
        ]);
    }
}
