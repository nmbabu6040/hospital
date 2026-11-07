@extends('admin.layouts.app')

@section('title', $report->exists ? 'Edit Report' : 'Add Report')

@section('content')
    <form
        action="{{ $report->exists ? route('admin.online-reports.update', $report) : route('admin.online-reports.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($report->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Patient Name <span class="text-red-500">*</span></label>
            <input type="text" name="patient_name" value="{{ old('patient_name', $report->patient_name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patient ID</label>
                <input type="text" name="patient_id" value="{{ old('patient_id', $report->patient_id) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone', $report->phone) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Report ID (ফাঁকা রাখলে auto-generate হবে)</label>
            <input type="text" name="report_id" value="{{ old('report_id', $report->report_id) }}"
                placeholder="RPT-XXXXXXXX" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Report Date</label>
            <input type="date" name="report_date"
                value="{{ old('report_date', $report->report_date?->format('Y-m-d')) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ready" {{ old('status', $report->status) == 'ready' ? 'selected' : '' }}>Ready</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Report File (PDF) {{ $report->exists ? '' : '*' }}</label>
            @if ($report->report_file)
                <p class="text-xs text-gray-500 mb-2"><a href="{{ asset('storage/' . $report->report_file) }}" target="_blank"
                        class="text-blue-600">Current PDF</a></p>
            @endif
            <input type="file" name="report_file" accept="application/pdf" {{ $report->exists ? '' : 'required' }}
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">ফাইল আপলোড করলে status অটো "Ready" হয়ে যাবে।</p>
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
