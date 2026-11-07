@extends('layouts.app')

@section('title', __('site.diagnostics'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.diagnostics') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($diagnostics as $diagnostic)
                <a href="{{ route('diagnostics.show', $diagnostic) }}" class="card">
                    <img src="{{ $diagnostic->image ? asset('storage/' . $diagnostic->image) : 'https://placehold.co/400x250?text=' . urlencode($diagnostic->name) }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $diagnostic->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">{{ $diagnostic->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($diagnostic->address, 60) }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No diagnostic centers found.</p>
            @endforelse
        </div>
    </section>
@endsection
