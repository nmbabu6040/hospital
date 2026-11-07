@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 150))

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-10">

        @if ($page->featured_image)
            <img src="{{ asset('storage/' . $page->featured_image) }}" class="w-full h-72 object-cover rounded-lg mb-6"
                loading="lazy" alt="{{ $page->title }}">
        @endif

        <h1 class="text-2xl md:text-3xl font-bold mb-6">{{ $page->title }}</h1>

        <div class="bg-white rounded-lg shadow-sm p-6 prose max-w-none text-gray-700 leading-relaxed dark:text-gray-300">
            {!! nl2br(e($page->content)) !!}
        </div>

    </section>
@endsection
