<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Doctor Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-100 flex-shrink-0 hidden md:flex md:flex-col">
            <div class="p-5 border-b border-gray-100">
                <p class="font-bold text-brand">{{ config('app.name') }}</p>
                <p class="text-xs text-gray-400 mt-1">Doctor Portal</p>
            </div>
            <nav class="p-4 space-y-1 text-sm flex-1">
                <a href="{{ route('doctor.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.dashboard') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
                <a href="{{ route('doctor.appointments') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.appointments') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">My
                    Appointments</a>
                <a href="{{ route('doctor.schedule') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.schedule') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">My
                    Schedule</a>
            </nav>
            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('doctor.logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="bg-white shadow-sm px-6 py-4">
                <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
            </header>
            <main class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6">
                        {{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
