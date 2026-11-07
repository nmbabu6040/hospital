@extends('layouts.app')

@section('title', __('site.online_report'))

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 text-center">{{ __('site.online_report') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-8">আপনার রিপোর্ট ডাউনলোড করতে Report ID ও ফোন নম্বর দিন।
        </p>

        @if ($errors->any())
            <div
                class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($report))
            <div
                class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6 text-center dark:bg-green-900/20 dark:border-green-800">
                <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-semibold text-lg mb-1">{{ $report->patient_name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Report ID: {{ $report->report_id }} | Date:
                    {{ $report->report_date?->format('d M, Y') }}</p>

                @if ($report->report_file)
                    <a href="{{ route('online-report.download', $report) }}" target="_blank" class="btn-primary">📄 Download
                        Report (PDF)</a>
                @elseif($report->hasGeneratedReport())
                    <a href="{{ route('online-report.pdf', $report) }}" target="_blank" class="btn-primary">📄 View /
                        Download Report (PDF)</a>
                    <p class="text-xs text-gray-400 mt-3">PDF খুললে ব্রাউজারের Print (Ctrl+P) অপশন থেকে প্রিন্ট বা Save করতে
                        পারবেন।</p>
                @endif
            </div>
        @endif

        <form action="{{ route('online-report.search') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Report ID <span class="text-red-500">*</span></label>
                <input type="text" name="report_id" value="{{ old('report_id') }}" required placeholder="RPT-XXXXXXXX"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">{{ __('site.phone') }} <span
                        class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <button type="submit" class="btn-primary w-full">{{ __('site.submit') }}</button>
        </form>
    </section>
@endsection
