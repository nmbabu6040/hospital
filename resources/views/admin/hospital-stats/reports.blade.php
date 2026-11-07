@extends('admin.layouts.app')

@section('title', 'Patient Statistics Reports')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-lg font-semibold">Patient Statistics Reports</h2>
        <a href="{{ route('admin.hospital-stats.index') }}" class="text-sm text-brand hover:underline">← Back to Entries</a>
    </div>

    {{-- Period Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach (['daily' => 'Daily (14 days)', 'weekly' => 'Weekly (12 weeks)', 'monthly' => 'Monthly (12 months)', 'yearly' => 'Yearly (5 years)'] as $key => $label)
            <a href="{{ route('admin.hospital-stats.reports', array_filter(['period' => $key, 'hospital_id' => $hospitalId])) }}"
                class="px-4 py-2 rounded-md text-sm font-medium {{ $period == $key ? 'bg-brand text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <form method="GET" class="mb-6">
        <input type="hidden" name="period" value="{{ $period }}">
        <select name="hospital_id" onchange="this.form.submit()"
            class="border border-gray-200 rounded-md px-4 py-2 text-sm">
            <option value="">All Hospitals Combined</option>
            @foreach ($hospitals as $hospital)
                <option value="{{ $hospital->id }}" {{ $hospitalId == $hospital->id ? 'selected' : '' }}>
                    {{ $hospital->name }}</option>
            @endforeach
        </select>
    </form>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white">
            <p class="text-xs opacity-80 uppercase tracking-wide">Admitted</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($summary['total_admitted']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white">
            <p class="text-xs opacity-80 uppercase tracking-wide">Discharged</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($summary['total_discharged']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white">
            <p class="text-xs opacity-80 uppercase tracking-wide">Test Only</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($summary['total_test_only']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white">
            <p class="text-xs opacity-80 uppercase tracking-wide">OPD</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($summary['total_opd']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-5 text-white">
            <p class="text-xs opacity-80 uppercase tracking-wide">Emergency</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($summary['total_emergency']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Patient Trend — {{ ucfirst($period) }}
            ({{ $startDate->format('d M, Y') }} – {{ $endDate->format('d M, Y') }})</h3>
        <canvas id="statsTrendChart" height="90"></canvas>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Patient Type Distribution</h3>
            <canvas id="statsDoughnutChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Admitted vs Test-Only Comparison</h3>
            <canvas id="statsBarChart" height="200"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            const labels = {!! json_encode($chartLabels) !!};
            const admittedData = {!! json_encode($admittedData) !!};
            const testOnlyData = {!! json_encode($testOnlyData) !!};
            const opdData = {!! json_encode($opdData) !!};
            const emergencyData = {!! json_encode($emergencyData) !!};

            // Line Chart — Trend
            new Chart(document.getElementById('statsTrendChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Admitted',
                            data: admittedData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Test Only',
                            data: testOnlyData,
                            borderColor: '#a855f7',
                            backgroundColor: 'rgba(168,85,247,0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'OPD',
                            data: opdData,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245,158,11,0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Emergency',
                            data: emergencyData,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            fill: true,
                            tension: 0.4
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

            // Doughnut Chart — Distribution
            const totalAdmitted = admittedData.reduce((a, b) => a + b, 0);
            const totalTestOnly = testOnlyData.reduce((a, b) => a + b, 0);
            const totalOpd = opdData.reduce((a, b) => a + b, 0);
            const totalEmergency = emergencyData.reduce((a, b) => a + b, 0);

            new Chart(document.getElementById('statsDoughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Admitted', 'Test Only', 'OPD', 'Emergency'],
                    datasets: [{
                        data: [totalAdmitted, totalTestOnly, totalOpd, totalEmergency],
                        backgroundColor: ['#3b82f6', '#a855f7', '#f59e0b', '#ef4444'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Bar Chart — Comparison
            new Chart(document.getElementById('statsBarChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Admitted',
                            data: admittedData,
                            backgroundColor: '#3b82f6'
                        },
                        {
                            label: 'Test Only',
                            data: testOnlyData,
                            backgroundColor: '#a855f7'
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
