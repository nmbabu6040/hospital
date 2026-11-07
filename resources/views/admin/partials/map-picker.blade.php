@php
    $pickerLat = old('latitude', $model->latitude ?? 23.8103);
    $pickerLng = old('longitude', $model->longitude ?? 90.4125);
    $pickerId = 'map-picker-' . Str::random(6);
@endphp

<div>
    <label class="block text-sm font-medium mb-1">Location on Map</label>
    <p class="text-xs text-gray-400 mb-2">ম্যাপে ক্লিক করে সঠিক লোকেশন বসাও, অথবা নিচে সার্চ বক্সে ঠিকানা লিখে খুঁজে বের
        করো।</p>

    <input type="text" id="{{ $pickerId }}-search" placeholder="ঠিকানা সার্চ করো (যেমন: Dhanmondi, Dhaka)"
        class="w-full border border-gray-200 rounded-md px-4 py-2 text-sm mb-2">

    <div id="{{ $pickerId }}" class="w-full h-64 rounded-md border border-gray-200"></div>

    <div class="grid grid-cols-2 gap-3 mt-2">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Latitude</label>
            <input type="text" name="latitude" id="{{ $pickerId }}-lat" value="{{ $pickerLat }}" readonly
                class="w-full border border-gray-200 rounded-md px-3 py-1.5 text-sm bg-gray-50 dark:bg-gray-800">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Longitude</label>
            <input type="text" name="longitude" id="{{ $pickerId }}-lng" value="{{ $pickerLng }}" readonly
                class="w-full border border-gray-200 rounded-md px-3 py-1.5 text-sm bg-gray-50 dark:bg-gray-800">
        </div>
    </div>
</div>

@once
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endonce

<script>
    (function() {
        function initPicker() {
            const mapEl = document.getElementById('{{ $pickerId }}');
            if (!mapEl || mapEl._leaflet_id) return;

            const latInput = document.getElementById('{{ $pickerId }}-lat');
            const lngInput = document.getElementById('{{ $pickerId }}-lng');
            const searchInput = document.getElementById('{{ $pickerId }}-search');

            const initialLat = parseFloat(latInput.value) || 23.8103;
            const initialLng = parseFloat(lngInput.value) || 90.4125;

            const map = L.map(mapEl).setView([initialLat, initialLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            const marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            function updateInputs(lat, lng) {
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
            }

            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                updateInputs(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateInputs(e.latlng.lat, e.latlng.lng);
            });

            // Address search (Nominatim, free OpenStreetMap geocoder)
            let searchTimeout;
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    if (!query) return;

                    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(
                            query + ', Bangladesh'))
                        .then(res => res.json())
                        .then(results => {
                            if (results.length > 0) {
                                const lat = parseFloat(results[0].lat);
                                const lng = parseFloat(results[0].lon);
                                map.setView([lat, lng], 15);
                                marker.setLatLng([lat, lng]);
                                updateInputs(lat, lng);
                            } else {
                                alert(
                                    'ঠিকানাটি খুঁজে পাওয়া যায়নি, ম্যাপে সরাসরি ক্লিক করে লোকেশন বসাও।');
                            }
                        });
                }
            });

            // Ensure map renders correctly if it's inside a hidden/collapsed container
            setTimeout(() => map.invalidateSize(), 300);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPicker);
        } else {
            initPicker();
        }
    })();
</script>
