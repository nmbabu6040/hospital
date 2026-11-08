@extends('patient.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase font-medium">Total Appointments</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['appointments'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase font-medium">Total Reports</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['reports'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase font-medium">Total Invoices</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['invoices'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Recent Appointments</h3>
                <a href="{{ route('patient.appointments') }}" class="text-xs text-brand hover:underline">View All →</a>
            </div>
            @forelse($appointments as $appointment)
                <div class="flex items-center justify-between border-b border-gray-50 py-2.5 last:border-0">
                    <div>
                        <p class="text-sm font-medium">{{ $appointment->doctor?->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">
                            {{ \Illuminate\Support\Carbon::parse($appointment->date)->format('d M, Y') }}</p>
                    </div>
                    <span
                        class="text-xs px-2 py-1 rounded-full {{ $appointment->status == 'Confirmed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $appointment->status }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4">কোনো অ্যাপয়েন্টমেন্ট নেই।</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Recent Reports</h3>
                <a href="{{ route('patient.reports') }}" class="text-xs text-brand hover:underline">View All →</a>
            </div>
            @forelse($reports as $report)
                <div class="flex items-center justify-between border-b border-gray-50 py-2.5 last:border-0">
                    <div>
                        <p class="text-sm font-medium">{{ $report->report_id }}</p>
                        <p class="text-xs text-gray-400">{{ $report->report_date?->format('d M, Y') }}</p>
                    </div>
                    <span
                        class="text-xs px-2 py-1 rounded-full {{ $report->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($report->status) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4">কোনো রিপোর্ট নেই।</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 mt-5">
            <h3 class="font-semibold mb-4">Video Consultations</h3>
            @forelse($consultations as $consultation)
                <div class="flex items-center justify-between border-b border-gray-50 py-2.5 last:border-0">
                    <div>
                        <p class="text-sm font-medium">{{ $consultation->doctor?->name ?? 'Any Doctor' }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $consultation->scheduled_at?->format('d M, Y h:i A') ?? $consultation->preferred_date->format('d M, Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs px-2 py-1 rounded-full {{ $consultation->status == 'scheduled' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($consultation->status) }}</span>
                        @if ($consultation->isJoinable())
                            <a href="{{ route('video-consultation.join', $consultation) }}" target="_blank"
                                class="btn-primary text-xs px-3 py-1.5">Join Now</a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4">কোনো ভিডিও কনসালটেশন নেই। <a
                        href="{{ route('video-consultation.create') }}" class="text-brand hover:underline">নতুন রিকোয়েস্ট
                        করুন</a>।</p>
            @endforelse
        </div>
    </div>
@endsection
