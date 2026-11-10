@extends('doctor.layouts.app')

@section('title', 'My Schedule')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold mb-4">Weekly Schedule</h3>
        @forelse($schedules as $schedule)
            <div class="flex items-center justify-between bg-gray-50 rounded-md px-4 py-3 mb-2">
                <span class="text-sm">{{ $schedule->dayName() }}</span>
                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</span>
            </div>
        @empty
            <p class="text-sm text-gray-400">কোনো শিডিউল সেট করা নেই। Admin-এর সাথে যোগাযোগ করুন।</p>
        @endforelse
        <p class="text-xs text-gray-400 mt-4">শিডিউল পরিবর্তনের জন্য Admin-এর সাথে যোগাযোগ করুন।</p>
    </div>
@endsection
