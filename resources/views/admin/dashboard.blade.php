@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Hero Stats — Gradient Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        <div
            class="relative overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 shadow-lg">
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
            <p class="text-xs opacity-80 uppercase tracking-wide font-medium">Total Doctors</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['doctors'] }}</p>
            <p class="text-xs opacity-70 mt-2">{{ $counts['departments'] }} Departments</p>
        </div>

        <div
            class="relative overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700 shadow-lg">
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-xs opacity-80 uppercase tracking-wide font-medium">Appointments</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['appointments'] }}</p>
            <p class="text-xs opacity-70 mt-2">{{ $counts['pending_appointments'] }} pending</p>
        </div>

        <div
            class="relative overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 shadow-lg">
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-xs opacity-80 uppercase tracking-wide font-medium">New Messages</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['messages'] }}</p>
            <p class="text-xs opacity-70 mt-2">{{ $counts['pending_comments'] }} pending comments</p>
        </div>

        <div
            class="relative overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br from-fuchsia-500 via-purple-600 to-violet-700 shadow-lg">
            <svg class="absolute -right-4 -bottom-4 w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xs opacity-80 uppercase tracking-wide font-medium">Hospitals & Diagnostics</p>
            <p class="text-3xl font-bold mt-1">{{ $counts['hospitals'] + $counts['diagnostics'] }}</p>
            <p class="text-xs opacity-70 mt-2">{{ $counts['hospitals'] }} Hospitals, {{ $counts['diagnostics'] }}
                Diagnostics</p>
        </div>

    </div>

    {{-- Patient Statistics — Colorful Quick View --}}
    <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Patient Statistics</h3>
            <a href="{{ route('admin.hospital-stats.reports') }}" class="text-xs text-brand hover:underline">Full Reports
                →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs text-blue-600 font-medium uppercase">Today — Admitted</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $patientSummary['today_admitted'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs text-purple-600 font-medium uppercase">Today — Test Only</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $patientSummary['today_test_only'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs text-blue-600 font-medium uppercase">This Month — Admitted</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $patientSummary['month_admitted'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs text-purple-600 font-medium uppercase">This Month — Test Only</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $patientSummary['month_test_only'] }}</p>
            </div>
        </div>
        @if ($patientSummary['today_admitted'] == 0 && $patientSummary['today_test_only'] == 0)
            <p class="text-xs text-amber-600 mt-3">⚠️ আজকের কোনো এন্ট্রি দেওয়া হয়নি। <a
                    href="{{ route('admin.hospital-stats.create') }}" class="underline">এখনই যোগ করুন</a>।</p>
        @endif
    </div>

    {{-- Charts Row 1 --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Appointments — Last 7 Days</h3>
            <canvas id="appointmentTrendChart" height="110"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Appointment Status</h3>
            <canvas id="statusPieChart" height="180"></canvas>
        </div>
    </div>

    {{-- Charts Row 2 — Monthly Patient Combo Chart --}}
    <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Admitted vs Test-Only — Last 6 Months</h3>
        <canvas id="monthlyComboChart" height="90"></canvas>
    </div>

    {{-- Top Performers --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">🏆 Top Doctors (By Appointments)</h3>
            <div class="space-y-3">
                @forelse($topDoctors as $index => $item)
                    <div class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0
                        {{ $index == 0 ? 'bg-amber-400' : ($index == 1 ? 'bg-gray-400' : ($index == 2 ? 'bg-orange-400' : 'bg-gray-200 text-gray-500')) }}">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $item->doctor->name }}</p>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                                <div class="bg-brand h-1.5 rounded-full"
                                    style="width: {{ $topDoctors->first() ? ($item->total / $topDoctors->first()->total) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-600 flex-shrink-0">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">কোনো অ্যাপয়েন্টমেন্ট ডেটা নেই।</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">📊 Top Departments (By Doctor Count)</h3>
            <div class="space-y-3">
                @forelse($topDepartments as $index => $dept)
                    <div class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0
                        {{ $index == 0 ? 'bg-emerald-500' : ($index == 1 ? 'bg-teal-400' : ($index == 2 ? 'bg-cyan-400' : 'bg-gray-200 text-gray-500')) }}">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $dept->name }}</p>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                                <div class="bg-emerald-500 h-1.5 rounded-full"
                                    style="width: {{ $topDepartments->first() && $topDepartments->first()->doctors_count ? ($dept->doctors_count / $topDepartments->first()->doctors_count) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-600 flex-shrink-0">{{ $dept->doctors_count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">কোনো ডেটা নেই।</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Appointments</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs text-brand hover:underline">View All →</a>
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

    {{-- Content Overview Mini Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $contentSummary['hospitals'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Active Hospitals</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <p class="text-2xl font-bold text-purple-600">{{ $contentSummary['diagnostics'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Active Diagnostics</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <p class="text-2xl font-bold text-amber-600">{{ $contentSummary['packages'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Health Packages</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <p class="text-2xl font-bold text-emerald-600">{{ $contentSummary['news'] }}</p>
            <p class="text-xs text-gray-500 mt-1">News Articles</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.doctors.create') }}" class="btn-outline text-sm">+ Add Doctor</a>
            <a href="{{ route('admin.news.create') }}" class="btn-outline text-sm">+ Add News</a>
            <a href="{{ route('admin.packages.create') }}" class="btn-outline text-sm">+ Add Package</a>
            <a href="{{ route('admin.sliders.create') }}" class="btn-outline text-sm">+ Add Slider</a>
            <a href="{{ route('admin.hospital-stats.create') }}" class="btn-outline text-sm">📝 Add Today's Stats</a>
            <a href="{{ route('admin.settings.edit') }}" class="btn-outline text-sm">⚙ Site Settings</a>
        </div>
    </div>

    @push('scripts')
        <script>
            // Appointment Trend — Line Chart
            new Chart(document.getElementById('appointmentTrendChart'), {
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

            // Appointment Status — Doughnut Chart
            new Chart(document.getElementById('statusPieChart'), {
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

            // Monthly Admitted vs Test-Only — Combo Bar Chart
            new Chart(document.getElementById('monthlyComboChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                            label: 'Admitted',
                            data: {!! json_encode($monthlyAdmitted) !!},
                            backgroundColor: '#3b82f6',
                            borderRadius: 6,
                        },
                        {
                            label: 'Test Only',
                            data: {!! json_encode($monthlyTestOnly) !!},
                            backgroundColor: '#a855f7',
                            borderRadius: 6,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush

@endsection
