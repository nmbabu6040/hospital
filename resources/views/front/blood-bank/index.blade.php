@extends('layouts.app')

@section('title', 'Blood Bank')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8 8 4 11.5 4 15.5a8 8 0 0016 0C20 11.5 16 8 12 2z" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Blood Bank</h1>
            <p class="text-gray-500 dark:text-gray-400">এক ব্যাগ রক্ত বাঁচাতে পারে একটি প্রাণ। Donor খুঁজুন অথবা নিজে Donor
                হোন।</p>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <a href="{{ route('blood-bank.register') }}" class="btn-primary">🩸 Register as Donor</a>
            <a href="{{ route('blood-bank.request') }}" class="btn-outline">🆘 Request Blood</a>
        </div>

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 text-sm max-w-2xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        {{-- Open Blood Requests --}}
        @if ($openRequests->count())
            <div class="mb-10">
                <h2 class="text-lg font-bold mb-4 text-red-600">🆘 Urgent Blood Requests</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($openRequests as $request)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $request->blood_group }}</span>
                                <span class="text-xs text-gray-500">{{ $request->bags_needed }} bag(s)</span>
                            </div>
                            <p class="font-medium text-sm">{{ $request->patient_name }}</p>
                            <p class="text-xs text-gray-500">{{ $request->hospital_name }}, {{ $request->district }}</p>
                            <p class="text-xs text-gray-500 mt-1">প্রয়োজন: {{ $request->needed_by_date->format('d M, Y') }}
                            </p>
                            <a href="tel:{{ $request->contact_phone }}"
                                class="text-xs text-red-600 font-medium hover:underline mt-2 inline-block">📞
                                {{ $request->contact_phone }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Donor Search --}}
        <h2 class="text-lg font-bold mb-4">Find a Donor</h2>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow-sm mb-8">
            <select name="blood_group" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
                <option value="">All Blood Groups</option>
                @foreach ($bloodGroups as $group)
                    <option value="{{ $group }}" {{ request('blood_group') == $group ? 'selected' : '' }}>
                        {{ $group }}</option>
                @endforeach
            </select>
            <input type="text" name="district" value="{{ request('district') }}" placeholder="District (e.g. Dhaka)"
                class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <button type="submit" class="btn-primary text-sm">Search</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse($donors as $donor)
                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span
                            class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">{{ $donor->blood_group }}</span>
                        @if ($donor->is_verified)
                            <span class="text-xs text-green-600 flex items-center gap-1">✓ Verified</span>
                        @endif
                    </div>
                    <h3 class="font-semibold">{{ $donor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $donor->district }}{{ $donor->area ? ', ' . $donor->area : '' }}
                    </p>
                    @if ($donor->last_donation_date)
                        <p class="text-xs text-gray-400 mt-1">Last donated:
                            {{ $donor->last_donation_date->format('d M, Y') }}</p>
                    @endif
                    @if ($donor->isEligibleNow())
                        <span class="text-xs text-green-600">● Eligible to donate now</span>
                    @else
                        <span class="text-xs text-amber-600">● Needs more recovery time</span>
                    @endif
                    <a href="tel:{{ $donor->phone }}" class="btn-outline text-sm w-full text-center mt-4 block">📞 Call
                        Donor</a>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">কোনো donor পাওয়া যায়নি। অনুসন্ধান পরিবর্তন করে
                    দেখুন।</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $donors->links() }}</div>
    </section>
@endsection
