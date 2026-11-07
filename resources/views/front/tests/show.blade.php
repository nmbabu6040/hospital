@extends('layouts.app')

@section('title', $test->meta_title ?: $test->name)
@section('meta_description', $test->meta_description ?: Str::limit(strip_tags($test->description), 150))

@section('content')
    <section class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold mb-2">{{ $test->name }}</h1>
            <p class="text-brand font-bold text-2xl mb-6">৳{{ number_format($test->price) }}</p>

            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                    <p class="text-gray-400 text-xs">Sample Type</p>
                    <p class="font-medium">{{ $test->sample_type ?: 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                    <p class="text-gray-400 text-xs">Report Time</p>
                    <p class="font-medium">{{ $test->report_time ?: 'N/A' }}</p>
                </div>
            </div>

            @if ($test->description)
                <h2 class="font-semibold text-lg mb-2">About this Test</h2>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $test->description }}</p>
            @endif

            @if ($test->preparation)
                <h2 class="font-semibold text-lg mb-2">Preparation Instructions</h2>
                <p class="text-gray-600 leading-relaxed mb-6 whitespace-pre-line">{{ $test->preparation }}</p>
            @endif

            <a href="{{ route('appointment.create') }}" class="btn-primary">{{ __('site.book_appointment') }}</a>
        </div>

        @if ($relatedPackages->count())
            <h2 class="text-xl font-bold mt-10 mb-4">এই টেস্টটি যে প্যাকেজে আছে</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($relatedPackages as $package)
                    <a href="{{ route('packages.show', $package) }}" class="card p-4">
                        <h3 class="font-semibold text-sm">{{ $package->name }}</h3>
                        <p class="text-brand font-bold mt-1">৳{{ number_format($package->price) }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
