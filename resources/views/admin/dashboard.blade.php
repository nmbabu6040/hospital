@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Doctors</p>
                <p class="text-2xl font-bold text-gray-800">{{ $counts['doctors'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21v-13l9-4 9 4v13M9 21v-6a3 3 0 016 0v6" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Departments</p>
                <p class="text-2xl font-bold text-gray-800">{{ $counts['departments'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Appointments</p>
                <p class="text-2xl font-bold text-gray-800">{{ $counts['appointments'] }}</p>
                @if ($counts['pending_appointments'] > 0)
                    <p class="text-xs text-amber-600 font-medium mt-0.5">{{ $counts['pending_appointments'] }} pending</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">New Messages</p>
                <p class="text-2xl font-bold text-gray-800">{{ $counts['messages'] }}</p>
            </div>


        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-xl bg-pink-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Pending Comments</p>
                <p class="text-2xl font-bold text-gray-800">{{ $counts['pending_comments'] }}</p>
            </div>
        </div>

    </div>

    {{-- Secondary Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Hospitals</p>
                <p class="text-xl font-bold text-gray-800">{{ $counts['hospitals'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-teal-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Diagnostic Centers</p>
                <p class="text-xl font-bold text-gray-800">{{ $counts['diagnostics'] }}</p>
            </div>
        </div>
    </div>

    {{-- Patient Statistics Quick View --}}
    <div class="bg-white rounded-xl shadow-sm p-5 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Patient Statistics</h3>
            <a href="{{ route('admin.hospital-stats.reports') }}" class="text-xs text-brand hover:underline">Full Reports
                →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-xs text-blue-600 font-medium uppercase">Today — Admitted</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $patientSummary['today_admitted'] }}</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-xs text-purple-600 font-medium uppercase">Today — Test Only</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $patientSummary['today_test_only'] }}</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-xs text-blue-600 font-medium uppercase">This Month — Admitted</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $patientSummary['month_admitted'] }}</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-xs text-purple-600 font-medium uppercase">This Month — Test Only</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $patientSummary['month_test_only'] }}</p>
            </div>
        </div>
        @if ($patientSummary['today_admitted'] == 0 && $patientSummary['today_test_only'] == 0)
            <p class="text-xs text-amber-600 mt-3">⚠️ আজকের কোনো এন্ট্রি দেওয়া হয়নি। <a
                    href="{{ route('admin.hospital-stats.create') }}" class="underline">এখনই যোগ করুন</a>।</p>
        @endif
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Appointments — Last 7 Days</h3>
            <canvas id="appointmentTrendChart" height="110"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Appointment Status</h3>
            <canvas id="statusPieChart" height="180"></canvas>
        </div>

    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Appointments</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs text-brand hover:underline">View All
                    →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentAppointments as $appointment)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                        <div>
                            <p class="font-medium text-sm text-gray-800">{{ $appointment->name }}</p>
                            <p class="text-xs text-gray-400">{{ $appointment->doctor?->name ?? 'No doctor selected' }} ·
                                {{ \Illuminate\Support\Carbon::parse($appointment->date)->format('d M, Y') }}</p>
                        </div>
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $appointment->status == 'Confirmed' ? 'bg-green-100 text-green-700' : ($appointment->status == 'Cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $appointment->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No appointments yet.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Messages</h3>
                <a href="{{ route('admin.messages.index') }}" class="text-xs text-brand hover:underline">View All →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentMessages as $message)
                    <div class="flex items-start justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                        <div class="min-w-0">
                            <p class="font-medium text-sm text-gray-800 flex items-center gap-1.5">
                                {{ $message->name }}
                                @if (!$message->is_read)
                                    <span class="w-2 h-2 bg-brand rounded-full"></span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 truncate">{{ Str::limit($message->message, 50) }}</p>
                        </div>
                        <span
                            class="text-xs text-gray-400 whitespace-nowrap ml-2">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No messages yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm p-5 mt-8">
        <h3 class="font-semibold text-gray-700 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.doctors.create') }}" class="btn-outline text-sm">+ Add Doctor</a>
            <a href="{{ route('admin.news.create') }}" class="btn-outline text-sm">+ Add News</a>
            <a href="{{ route('admin.packages.create') }}" class="btn-outline text-sm">+ Add Package</a>
            <a href="{{ route('admin.sliders.create') }}" class="btn-outline text-sm">+ Add Slider</a>
            <a href="{{ route('admin.settings.edit') }}" class="btn-outline text-sm">⚙ Site Settings</a>
            <a href="{{ route('admin.backups.index') }}" class="btn-outline text-sm">💾 Backup Now</a>
        </div>
    </div>

    @push('scripts')
        <script>
            const trendCtx = document.getElementById('appointmentTrendChart');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Appointments',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#0e4d92',
                        backgroundColor: 'rgba(14, 77, 146, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0e4d92',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            const pieCtx = document.getElementById('statusPieChart');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Confirmed', 'Cancelled'],
                    datasets: [{
                        data: [{{ $statusCounts['Pending'] }}, {{ $statusCounts['Confirmed'] }},
                            {{ $statusCounts['Cancelled'] }}
                        ],
                        backgroundColor: ['#f59e0b', '#22c55e', '#ef4444'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15
                            }
                        }
                    }
                }
            });
        </script>
    @endpush

@endsection
