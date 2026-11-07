@extends('layouts.app')

@section('title', __('site.packages_vaccines'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.packages_vaccines') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($packages as $package)
                <a href="{{ route('packages.show', $package) }}" class="card">
                    <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://placehold.co/400x250?text=' . urlencode($package->name) }}"
                        class="w-full h-44 object-cover" loading="lazy" alt="{{ $package->name }}">
                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-2">{{ $package->name }}</h3>
                        <p class="text-brand font-bold text-xl">৳{{ number_format($package->price) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
