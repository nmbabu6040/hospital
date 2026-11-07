@extends('layouts.app')

@section('title', __('site.journal'))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.journal') }}</h1>

        <div class="space-y-4">
            @forelse($journals as $journal)
                <div class="bg-white rounded-lg shadow-sm p-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM13 9V3.5L18.5 9H13z" />
                        </svg>
                        <h3 class="font-medium">{{ $journal->title }}</h3>
                    </div>
                    <a href="{{ asset('storage/' . $journal->pdf_file) }}" target="_blank" class="btn-outline text-sm">Download
                        PDF</a>
                </div>
            @empty
                <p class="text-center text-gray-500 py-10">No journal entries yet.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $journals->links() }}
        </div>
    </section>
@endsection
