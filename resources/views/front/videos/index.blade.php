@extends('layouts.app')

@section('title', __('site.videos'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.videos') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($videos as $video)
                <div>
                    <div class="aspect-video rounded-lg overflow-hidden shadow-sm">
                        <iframe class="w-full h-full" src="{{ $video->youtube_url }}" title="{{ $video->title }}"
                            frameborder="0" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <h3 class="font-medium mt-2">{{ $video->title }}</h3>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No videos yet.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $videos->links() }}
        </div>
    </section>
@endsection
