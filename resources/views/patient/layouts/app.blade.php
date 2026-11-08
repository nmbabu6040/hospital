<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patient Portal') | {{ config('app.name') }}</title>

    @php($globalSetting = \App\Models\Setting::get())
    @if ($globalSetting->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $globalSetting->favicon) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-100 flex-shrink-0 hidden md:flex md:flex-col">
            <div class="p-5 border-b border-gray-100">
                <a href="{{ route('home') }}" class="text-xl font-bold text-brand">{{ config('app.name') }}</a>
                <p class="text-xs text-gray-400 mt-1">Patient Portal</p>
            </div>
            <nav class="p-4 space-y-1 text-sm flex-1">
                <a href="{{ route('patient.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.dashboard') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('patient.appointments') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.appointments') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="{{ route('patient.reports') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.reports') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    My Reports
                </a>
                <a href="{{ route('patient.invoices') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.invoices') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21l-2-1-2 1-2-1-2 1-2-1-2 1V3l2 1 2-1 2 1 2-1 2 1 2-1v18z" />
                    </svg>
                    My Invoices
                </a>
                <a href="{{ route('patient.profile') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.profile') ? 'bg-brand text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    My Profile
                </a>
            </nav>
            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('patient.logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 text-sm text-red-600 hover:underline w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="bg-white shadow-sm px-4 md:px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-2 text-sm">
                    <div
                        class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center text-xs font-semibold">
                        {{ strtoupper(substr(auth('patient')->user()->name, 0, 1)) }}
                    </div>
                    <span>{{ auth('patient')->user()->name }}</span>
                </div>
            </header>

            <main class="p-4 md:p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6">
                        {{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
