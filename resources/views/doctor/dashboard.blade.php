@extends('doctor.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase">Today's Appointments</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['today'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase">Total Appointments</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase">Average Rating</p>
            <p class="text-3xl font-bold text-amber-500 mt-1">{{ $counts['rating'] }} ⭐</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-xs uppercase">Total Reviews</p>
            <p class="text-3xl font-bold text-brand mt-1">{{ $counts['reviews'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold mb-4">Today's Appointments</h3>
        @forelse($todayAppointments as $appointment)
            <div class="flex items-center justify-between border-b border-gray-50 py-3 last:border-0">
                <div>
                    <p class="text-sm font-medium">{{ $appointment->name }}</p>
                    <p class="text-xs text-gray-400">{{ $appointment->phone }}
                        {{ $appointment->slot_time ? '· ' . \Carbon\Carbon::parse($appointment->slot_time)->format('h:i A') : '' }}
                    </p>
                </div>
                <span
                    class="text-xs px-2 py-1 rounded-full {{ $appointment->status == 'Confirmed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $appointment->status }}</span>
            </div>
        @empty
            <p class="text-sm text-gray-400 py-4">আজকে কোনো অ্যাপয়েন্টমেন্ট নেই।</p>
        @endforelse
    </div>
@endsection
