@extends('layouts.app')

@section('title', __('site.news'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.news') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($newsItems as $item)
                <a href="{{ route('news.show', $item) }}" class="card">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/400x250?text=News' }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $item->title }}">
                    <div class="p-5">
                        <p class="text-xs text-gray-400 mb-1">{{ $item->published_at?->format('d M, Y') }}</p>
                        <h3 class="font-semibold">{{ Str::limit($item->title, 70) }}</h3>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $newsItems->links() }}
        </div>
    </section>
@endsection
