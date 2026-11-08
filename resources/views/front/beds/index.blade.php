@extends('layouts.app')

@section('title', 'Bed Availability')

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Live Bed Availability</h1>
            <p class="text-gray-500 dark:text-gray-400">প্রতিটি হাসপাতালের বর্তমান বেড পরিস্থিতি</p>
        </div>

        @foreach ($hospitals as $hospital)
            @if ($hospital->bedCategories->count())
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold">{{ $hospital->name }}</h2>
                        <span class="text-sm text-gray-500">{{ $hospital->totalAvailableBeds() }} /
                            {{ $hospital->totalBeds() }} beds available</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($hospital->bedCategories as $category)
                            @php($color = $category->statusColor())
                            <div class="card p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-semibold text-sm">{{ $category->ward_name }}</h3>
                                    <span
                                        class="w-2.5 h-2.5 rounded-full {{ $color == 'red' ? 'bg-red-500' : ($color == 'amber' ? 'bg-amber-500' : 'bg-green-500') }}"></span>
                                </div>
                                <p
                                    class="text-2xl font-bold {{ $color == 'red' ? 'text-red-600' : ($color == 'amber' ? 'text-amber-600' : 'text-green-600') }}">
                                    {{ $category->available_beds }}
                                </p>
                                <p class="text-xs text-gray-400">available out of {{ $category->total_beds }}</p>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3">
                                    <div class="{{ $color == 'red' ? 'bg-red-500' : ($color == 'amber' ? 'bg-amber-500' : 'bg-green-500') }} h-1.5 rounded-full"
                                        style="width: {{ $category->occupancyPercent() }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if ($hospitals->every(fn($h) => $h->bedCategories->isEmpty()))
            <p class="text-center text-gray-500 py-10">বেড সংক্রান্ত তথ্য এই মুহূর্তে উপলব্ধ নেই।</p>
        @endif
    </section>
@endsection
