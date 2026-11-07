@extends('admin.layouts.app')

@section('title', 'Hospital Statistics')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-lg font-semibold">Daily Patient Statistics</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">প্রতিদিনের রোগী সংখ্যা এন্ট্রি দিন — এখান থেকেই
                Daily/Weekly/Monthly/Yearly রিপোর্ট তৈরি হবে।</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.hospital-stats.reports') }}" class="btn-outline">📊 View Reports</a>
            <a href="{{ route('admin.hospital-stats.create') }}" class="btn-primary">+ Add Today's Entry</a>
        </div>
    </div>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-lg shadow-sm mb-6">
        <input type="date" name="from" value="{{ request('from') }}"
            class="border border-gray-200 rounded-md px-3 py-2 text-sm">
        <input type="date" name="to" value="{{ request('to') }}"
            class="border border-gray-200 rounded-md px-3 py-2 text-sm">
        <select name="hospital_id" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Hospitals</option>
            @foreach ($hospitals as $hospital)
                <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                    {{ $hospital->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Hospital</th>
                    <th class="p-3">Admitted</th>
                    <th class="p-3">Discharged</th>
                    <th class="p-3">Test Only</th>
                    <th class="p-3">OPD</th>
                    <th class="p-3">Emergency</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats as $stat)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $stat->stat_date->format('d M, Y') }}</td>
                        <td class="p-3">{{ $stat->hospital?->name ?? 'All / N/A' }}</td>
                        <td class="p-3">{{ $stat->patients_admitted }}</td>
                        <td class="p-3">{{ $stat->patients_discharged }}</td>
                        <td class="p-3">{{ $stat->test_only_patients }}</td>
                        <td class="p-3">{{ $stat->opd_patients }}</td>
                        <td class="p-3">{{ $stat->emergency_patients }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.hospital-stats.edit', $stat) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.hospital-stats.destroy', $stat) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this entry?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500">কোনো এন্ট্রি নেই। "Add Today's Entry" দিয়ে
                            শুরু করো।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $stats->links() }}</div>
@endsection
