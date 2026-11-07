@extends('layouts.app')

@section('title', __('site.offers'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.offers') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($offers as $offer)
                <div class="card">
                    <img src="{{ $offer->image ? asset('storage/' . $offer->image) : 'https://placehold.co/400x250?text=Offer' }}"
                        class="w-full h-44 object-cover" loading="lazy" alt="{{ $offer->title }}">
                    <div class="p-5">
                        <h3 class="font-semibold mb-2">{{ $offer->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($offer->description, 80) }}</p>
                        @if ($offer->start_date && $offer->end_date)
                            <p class="text-xs text-brand">{{ $offer->start_date->format('d M') }} -
                                {{ $offer->end_date->format('d M, Y') }}</p>
                        @endif
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
                            <a href="https://wa.me/?text={{ urlencode($offer->title . ' - ' . url()->current()) }}"
                                target="_blank" rel="noopener" class="text-xs text-green-600 hover:underline">Share on
                                WhatsApp</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No offers currently running.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $offers->links() }}
        </div>
    </section>
@endsection
