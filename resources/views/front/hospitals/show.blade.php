@extends('layouts.app')

@section('title', $hospital->meta_title ?: $hospital->name)
@section('meta_description', $hospital->meta_description ?: Str::limit(strip_tags($hospital->description), 150))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <img src="{{ $hospital->image ? asset('storage/' . $hospital->image) : 'https://placehold.co/1200x400?text=' . urlencode($hospital->name) }}"
            class="w-full h-72 object-cover rounded-lg mb-6" loading="lazy" alt="{{ $hospital->name }}">

        <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $hospital->name }}</h1>
        <p class="text-gray-500 mb-6">{{ $hospital->address }} | {{ $hospital->phone }} | {{ $hospital->email }}</p>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <p class="text-gray-600 leading-relaxed mb-4">{{ $hospital->description }}</p>

            @if ($hospital->facilities)
                <h2 class="font-semibold text-lg mt-4 mb-2">Facilities</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $hospital->facilities }}</p>
            @endif
        </div>

        @if ($hospital->latitude && $hospital->longitude)
            <div id="hospital-map"
                class="rounded-lg overflow-hidden mb-10 h-72 border border-gray-100 dark:border-gray-800"></div>
            @push('scripts')
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                <script>
                    const hMap = L.map('hospital-map').setView([{{ $hospital->latitude }}, {{ $hospital->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(hMap);
                    L.marker([{{ $hospital->latitude }}, {{ $hospital->longitude }}]).addTo(hMap)
                        .bindPopup(@json($hospital->name)).openPopup();
                </script>
            @endpush
        @elseif($hospital->map_embed)
            <div class="rounded-lg overflow-hidden mb-10 [&_iframe]:w-full [&_iframe]:h-72">
                {!! $hospital->map_embed !!}
            </div>
        @endif

        <h2 class="text-xl font-bold mb-6">Doctors at this Hospital</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($doctors as $doctor)
                <a href="{{ route('doctors.show', $doctor) }}" class="card">
                    <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/300x300?text=' . urlencode($doctor->name) }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $doctor->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-sm">{{ $doctor->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $doctor->designation }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-gray-500">No doctors listed yet.</p>
            @endforelse
        </div>
    </section>
@endsection
