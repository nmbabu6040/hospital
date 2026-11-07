@extends('layouts.app')

@section('title', $diagnostic->meta_title ?: $diagnostic->name)
@section('meta_description', $diagnostic->meta_description ?: Str::limit(strip_tags($diagnostic->description), 150))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <img src="{{ $diagnostic->image ? asset('storage/' . $diagnostic->image) : 'https://placehold.co/1200x400?text=' . urlencode($diagnostic->name) }}"
            class="w-full h-72 object-cover rounded-lg mb-6" loading="lazy" alt="{{ $diagnostic->name }}">

        <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $diagnostic->name }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-6">{{ $diagnostic->address }} | {{ $diagnostic->phone }} |
            {{ $diagnostic->email }}</p>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            @if ($diagnostic->description)
                <p class="text-gray-600 leading-relaxed mb-4">{{ $diagnostic->description }}</p>
            @endif

            @if ($diagnostic->tests_available)
                <h2 class="font-semibold text-lg mt-4 mb-2">Tests Available</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    @foreach (explode("\n", $diagnostic->tests_available) as $test)
                        @if (trim($test))
                            <li>{{ trim($test) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        @if ($diagnostic->latitude && $diagnostic->longitude)
            <div id="diagnostic-map"
                class="rounded-lg overflow-hidden mb-6 h-72 border border-gray-100 dark:border-gray-800"></div>
            @push('scripts')
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                <script>
                    const dMap = L.map('diagnostic-map').setView([{{ $diagnostic->latitude }}, {{ $diagnostic->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(dMap);
                    L.marker([{{ $diagnostic->latitude }}, {{ $diagnostic->longitude }}]).addTo(dMap)
                        .bindPopup(@json($diagnostic->name)).openPopup();
                </script>
            @endpush
        @elseif($diagnostic->map_embed)
            <div class="rounded-lg overflow-hidden mb-6 [&_iframe]:w-full [&_iframe]:h-72">
                {!! $diagnostic->map_embed !!}
            </div>
        @endif

        <a href="{{ route('appointment.create') }}" class="btn-primary">{{ __('site.book_appointment') }}</a>
    </section>
@endsection
