<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Queue | {{ config('app.name') }}</title>
    <meta http-equiv="refresh" content="30">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-900 text-white min-h-screen p-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold">Now Serving</h1>
        <p class="text-gray-400 mt-2">{{ now()->format('d M, Y — h:i A') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        @forelse($queues as $queue)
            <div class="bg-gray-800 rounded-xl p-6 text-center border border-gray-700">
                <p class="text-sm text-gray-400 mb-1">{{ $queue->doctor->name }}</p>
                <p class="text-xs text-gray-500 mb-4">{{ $queue->doctor->department?->name }}</p>
                <p class="text-6xl font-bold text-brand">{{ $queue->current_serial ?? '—' }}</p>
                <p class="text-xs text-gray-400 mt-2">Current Serial</p>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-400 py-20">এই মুহূর্তে কোনো সক্রিয় কিউ নেই।</p>
        @endforelse
    </div>

    <p class="text-center text-gray-600 text-xs mt-10">Page auto-refreshes every 30 seconds</p>
</body>

</html>
