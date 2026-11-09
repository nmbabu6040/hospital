@extends('layouts.app')

@section('title', __('site.sister_concerns'))

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.sister_concerns') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($sisterConcerns as $sc)
                <a href="{{ $sc->website_url ?? '#' }}" target="_blank" class="card p-6 text-center">
                    <img src="{{ $sc->logo ? asset('storage/' . $sc->logo) : 'https://placehold.co/200x100?text=' . urlencode($sc->name) }}"
                        class="h-40 mx-auto mb-4" loading="lazy" alt="{{ $sc->name }}">
                    <h3 class="font-semibold mb-2">{{ $sc->name }}</h3>
                    <p class="text-sm text-gray-500">{{ Str::limit($sc->description, 80) }}</p>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No sister concerns added yet.</p>
            @endforelse
        </div>
    </section>
@endsection
