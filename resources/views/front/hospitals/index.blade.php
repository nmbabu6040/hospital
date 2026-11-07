@extends('layouts.app')

@section('title', __('site.hospitals'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.hospitals') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($hospitals as $hospital)
                <a href="{{ route('hospitals.show', $hospital) }}" class="card">
                    <img src="{{ $hospital->image ? asset('storage/' . $hospital->image) : 'https://placehold.co/400x250?text=' . urlencode($hospital->name) }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $hospital->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">{{ $hospital->name }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($hospital->address, 60) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
