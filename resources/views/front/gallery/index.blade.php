@extends('layouts.app')

@section('title', __('site.gallery'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.gallery') }}</h1>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($images as $image)
                <div class="rounded-lg overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $image->image) }}"
                        class="w-full h-48 object-cover hover:scale-105 transition" loading="lazy" alt="{{ $image->title }}">
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No images yet.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $images->links() }}
        </div>
    </section>
@endsection
