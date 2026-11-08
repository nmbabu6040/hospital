@extends('admin.layouts.app')

@section('title', 'Schedule: ' . $doctor->name)

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Schedule — {{ $doctor->name }}</h2>
        <a href="{{ route('admin.doctors.index') }}" class="text-sm text-brand hover:underline">← Back to Doctors</a>
    </div>

    {{-- Weekly Schedule --}}
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Weekly Schedule</h3>

        <form action="{{ route('admin.doctors.schedule.store', $doctor) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-6 items-end">
            @csrf
            <div>
                <label class="block text-xs text-gray-500 mb-1">Day</label>
                <select name="day_of_week" required class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
                    <option value="0">Sunday</option>
                    <option value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                    <option value="6">Saturday</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Start Time</label>
                <input type="time" name="start_time" required
                    class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">End Time</label>
                <input type="time" name="end_time" required
                    class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Slot (min)</label>
                <input type="number" name="slot_duration_minutes" value="15" min="5" max="120" required
                    class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Patients/Slot</label>
                <input type="number" name="max_patients_per_slot" value="1" min="1" max="20" required
                    class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
            </div>
            <button type="submit" class="btn-primary text-sm">+ Add</button>
        </form>

        <div class="space-y-2">
            @forelse($schedules as $schedule)
                <div class="flex items-center justify-between bg-gray-50 rounded-md px-4 py-3">
                    <div class="text-sm">
                        <strong>{{ $schedule->dayName() }}</strong> —
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} to
                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                        <span class="text-gray-400">({{ $schedule->slot_duration_minutes }} min slots,
                            {{ $schedule->max_patients_per_slot }} patient/slot)</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <form action="{{ route('admin.doctors.schedule.toggle', [$doctor, $schedule]) }}" method="POST">
                            @csrf @method('PATCH')
                            <button
                                class="px-2 py-1 rounded-full {{ $schedule->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.doctors.schedule.destroy', [$doctor, $schedule]) }}" method="POST"
                            onsubmit="return confirm('Delete this schedule?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-6">কোনো শিডিউল সেট করা নেই।</p>
            @endforelse
        </div>
    </div>

    {{-- Leave Days --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Leave / Off Days</h3>

        <form action="{{ route('admin.doctors.leave.store', $doctor) }}" method="POST" class="flex gap-3 mb-6">
            @csrf
            <input type="date" name="leave_date" required min="{{ now()->format('Y-m-d') }}"
                class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <input type="text" name="reason" placeholder="Reason (optional)"
                class="flex-1 border border-gray-200 rounded-md px-3 py-2 text-sm">
            <button type="submit" class="btn-primary text-sm">+ Add Leave</button>
        </form>

        <div class="space-y-2">
            @forelse($leaves as $leave)
                <div class="flex items-center justify-between bg-gray-50 rounded-md px-4 py-3">
                    <div class="text-sm">
                        <strong>{{ $leave->leave_date->format('d M, Y') }}</strong>
                        @if ($leave->reason)
                            <span class="text-gray-400">— {{ $leave->reason }}</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.doctors.leave.destroy', [$doctor, $leave]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-xs">Remove</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-6">কোনো ছুটির দিন সেট করা নেই।</p>
            @endforelse
        </div>
    </div>
@endsection
