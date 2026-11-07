@extends('layouts.app')

@section('title', $doctor->meta_title ?: $doctor->name)
@section('meta_description', $doctor->meta_description ?: Str::limit(strip_tags($doctor->bio), 150))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden md:flex">
            <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/400x400?text=' . urlencode($doctor->name) }}"
                class="w-full md:w-80 h-80 object-cover" loading="lazy" alt="{{ $doctor->name }}">

            <div class="p-6 flex-1">
                <h1 class="text-2xl font-bold">{{ $doctor->name }}</h1>
                <p class="text-brand font-medium mt-1">{{ $doctor->designation }}</p>
                <p class="text-gray-600 mt-1">{{ $doctor->degree }}</p>

                <div class="mt-4 space-y-2 text-sm text-gray-700">
                    <p><strong>Department:</strong> {{ $doctor->department?->name }}</p>
                    <p><strong>Hospital:</strong> {{ $doctor->hospital?->name }}</p>
                    <p><strong>Chamber Time:</strong> {{ $doctor->chamber_time }}</p>
                </div>

                @if ($doctor->bio)
                    <p class="text-gray-600 mt-4 leading-relaxed">{{ $doctor->bio }}</p>
                @endif

                <div class="flex flex-wrap items-center gap-4 mt-6">
                    <a href="{{ route('appointment.create', ['doctor' => $doctor->id]) }}" class="btn-primary">
                        {{ __('site.book_appointment') }}
                    </a>
                    @include('partials.social-share', ['title' => $doctor->name])
                </div>
            </div>
        </div>
    </section>
@endsection
