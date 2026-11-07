@extends('layouts.app')

@section('title', 'Our Locations')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Our Locations</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-8">আমাদের সকল হাসপাতাল ও ডায়াগনস্টিক সেন্টারের অবস্থান</p>

        <div id="all-locations-map"
            class="w-full h-[500px] rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 mb-8"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($hospitals->count())
                <div>
                    <h2 class="font-semibold text-lg mb-3">Hospitals</h2>
                    <div class="space-y-2">
                        @foreach ($hospitals as $hospital)
                            <a href="{{ route('hospitals.show', $hospital) }}"
                                class="block bg-white dark:bg-gray-900 rounded-md p-3 shadow-sm hover:shadow-md transition">
                                <p class="font-medium text-sm">{{ $hospital->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hospital->address }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($diagnostics->count())
                <div>
                    <h2 class="font-semibold text-lg mb-3">Diagnostic Centers</h2>
                    <div class="space-y-2">
                        @foreach ($diagnostics as $diagnostic)
                            <a href="{{ route('diagnostics.show', $diagnostic) }}"
                                class="block bg-white dark:bg-gray-900 rounded-md p-3 shadow-sm hover:shadow-md transition">
                                <p class="font-medium text-sm">{{ $diagnostic->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $diagnostic->address }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            const allMap = L.map('all-locations-map').setView([23.8103, 90.4125], 11);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(allMap);

            const bounds = [];

            @foreach ($hospitals as $hospital)
                {
                    const m = L.marker([{{ $hospital->latitude }}, {{ $hospital->longitude }}]).addTo(allMap);
                    m.bindPopup(
                        '<strong>{{ addslashes($hospital->name) }}</strong><br><a href="{{ route('hospitals.show', $hospital) }}">View Details</a>'
                        );
                    bounds.push([{{ $hospital->latitude }}, {{ $hospital->longitude }}]);
                }
            @endforeach

            @foreach ($diagnostics as $diagnostic)
                {
                    const m = L.marker([{{ $diagnostic->latitude }}, {{ $diagnostic->longitude }}], {
                        icon: L.icon({
                            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                        })
                    }).addTo(allMap);
                    m.bindPopup(
                        '<strong>{{ addslashes($diagnostic->name) }}</strong><br><a href="{{ route('diagnostics.show', $diagnostic) }}">View Details</a>'
                        );
                    bounds.push([{{ $diagnostic->latitude }}, {{ $diagnostic->longitude }}]);
                }
            @endforeach

            if (bounds.length > 0) {
                allMap.fitBounds(bounds, {
                    padding: [40, 40]
                });
            }
        </script>
    @endpush
@endsection
