@extends('layouts.app')

@section('title', $package->meta_title ?: $package->name)
@section('meta_description', $package->meta_description ?: Str::limit(strip_tags($package->description), 150))

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://placehold.co/800x400?text=' . urlencode($package->name) }}"
                class="w-full h-64 object-cover" loading="lazy" alt="{{ $package->name }}">

            <div class="p-6">
                <h1 class="text-2xl font-bold mb-2">{{ $package->name }}</h1>
                <p class="text-brand font-bold text-2xl mb-4">৳{{ number_format($package->price) }}</p>

                @if ($package->description)
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $package->description }}</p>
                @endif

                @if ($package->individualTests->count())
                    <h2 class="font-semibold text-lg mb-3">Tests Included ({{ $package->individualTests->count() }})</h2>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700 mb-6">
                        @foreach ($package->individualTests as $test)
                            <a href="{{ route('tests.show', $test) }}"
                                class="flex items-center justify-between py-2.5 hover:text-brand transition">
                                <span>{{ $test->name }}</span>
                                <span class="text-xs text-gray-400">৳{{ number_format($test->price) }}</span>
                            </a>
                        @endforeach
                    </div>
                @elseif($package->tests)
                    <h2 class="font-semibold text-lg mb-3">Tests Included</h2>
                    <ul class="list-disc list-inside text-gray-600 space-y-1">
                        @foreach (explode("\n", $package->tests) as $test)
                            @if (trim($test))
                                <li>{{ trim($test) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                <div class="flex flex-wrap items-center gap-4 mt-6">
                    <a href="{{ route('appointment.create') }}" class="btn-primary">{{ __('site.book_appointment') }}</a>
                    @include('partials.social-share', ['title' => $package->name])
                </div>
            </div>
        </div>
    </section>
@endsection
