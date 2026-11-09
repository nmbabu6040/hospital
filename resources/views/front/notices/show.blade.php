@extends('layouts.app')

@section('title', $notice->title)

@section('content')
    <section class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <span class="text-xs bg-brand/10 text-brand px-2 py-1 rounded-full">{{ $notice->category }}</span>
            <h1 class="text-2xl font-bold mt-3 mb-2">{{ $notice->title }}</h1>
            <p class="text-sm text-gray-400 mb-6">Published: {{ $notice->publish_date->format('d M, Y') }}</p>

            @if ($notice->description)
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line mb-6">
                    {{ $notice->description }}</p>
            @endif

            @if ($notice->attachment_file)
                <a href="{{ asset('storage/' . $notice->attachment_file) }}" target="_blank" class="btn-primary inline-block">📎
                    Download Attachment</a>
            @endif
        </div>
    </section>
@endsection
