<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin Panel</title>

    @php($globalSetting = \App\Models\Setting::get())
    @if ($globalSetting->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $globalSetting->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script>
        if (localStorage.getItem('admin-theme') === 'dark' ||
            (!localStorage.getItem('admin-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php($adminThemeSetting = \App\Models\Setting::get())
    <style>
        :root {
            --color-brand: {{ $adminThemeSetting->themePrimaryColor() }};
            --color-brand-dark: {{ $adminThemeSetting->themePrimaryDarkColor() }};
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-800 h-screen overflow-hidden" x-data="{ sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true', mobileSidebarOpen: false }">

    <div class="flex h-screen">

        {{-- Mobile overlay --}}
        <div x-show="mobileSidebarOpen" x-cloak @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarCollapsed ? 'md:w-20' : 'md:w-64'"
            class="fixed md:static inset-y-0 left-0 z-40 w-64 h-full bg-gray-900 text-gray-300 flex-shrink-0 transform transition-all duration-300 md:translate-x-0 overflow-y-auto flex flex-col"
            x-bind:class="{ '-translate-x-full': !mobileSidebarOpen, 'translate-x-0': mobileSidebarOpen }">
            <div class="p-5 border-b border-gray-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-xl font-bold text-white flex items-center gap-2 overflow-hidden whitespace-nowrap">
                    <svg class="w-7 h-7 text-brand flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-cloak>Admin Panel</span>
                </a>
                <button @click="mobileSidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="p-3 space-y-5 text-sm flex-1">

                {{-- Overview --}}
                <div>
                    <p x-show="!sidebarCollapsed" x-cloak
                        class="px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Overview</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Dashboard</span>
                    </a>
                </div>

                {{-- Medical Content --}}
                <div>
                    <p x-show="!sidebarCollapsed" x-cloak
                        class="px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Medical
                        Content</p>

                    <a href="{{ route('admin.doctors.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.doctors.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Doctors</span>
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.departments.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21v-13l9-4 9 4v13M9 21v-6a3 3 0 016 0v6" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Departments</span>
                    </a>
                    <a href="{{ route('admin.hospitals.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.hospitals.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Hospitals</span>
                    </a>
                    <a href="{{ route('admin.diagnostics.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.diagnostics.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Diagnostics</span>
                    </a>
                    <a href="{{ route('admin.packages.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.packages.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Packages</span>
                    </a>

                    <a href="{{ route('admin.tests.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.tests.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Tests</span>
                    </a>
                </div>

                {{-- Media --}}
                <div>
                    <p x-show="!sidebarCollapsed" x-cloak
                        class="px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Media</p>

                    <a href="{{ route('admin.news.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>News</span>
                    </a>
                    <a href="{{ route('admin.gallery.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 8a2 2 0 01-2-2m18 2a2 2 0 002-2M4 8v10a2 2 0 002 2h12a2 2 0 002-2V8M4 8l2-4h12l2 4" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Gallery</span>
                    </a>
                    <a href="{{ route('admin.offers.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.offers.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.023.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Offers</span>
                    </a>
                    <a href="{{ route('admin.videos.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.videos.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Videos</span>
                    </a>
                    <a href="{{ route('admin.journals.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.journals.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Journals</span>
                    </a>
                    <a href="{{ route('admin.sliders.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 9h16M4 15h16" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Sliders</span>
                    </a>
                    <a href="{{ route('admin.sister-concerns.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.sister-concerns.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-3-3.87M7 10a4 4 0 100-8" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Sister Concerns</span>
                    </a>

                    <a href="{{ route('admin.about-content.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.about-content.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>About Content</span>
                    </a>
                    <a href="{{ route('admin.accreditations.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.accreditations.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Accreditations</span>
                    </a>

                    <a href="{{ route('admin.pages.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Custom Pages</span>
                    </a>
                </div>

                {{-- Management --}}
                <div>
                    <p x-show="!sidebarCollapsed" x-cloak
                        class="px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Management
                    </p>

                    <a href="{{ route('admin.appointments.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.appointments.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak class="flex-1">Appointments</span>
                    </a>

                    <a href="{{ route('admin.hospital-stats.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.hospital-stats.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Hospital Stats</span>
                    </a>
                    <a href="{{ route('admin.messages.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Messages</span>
                    </a>

                    @php($pendingCommentsCount = \App\Models\Comment::where('status', 'pending')->count())
                    <a href="{{ route('admin.comments.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.comments.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak class="flex-1">Comments</span>
                        @if ($pendingCommentsCount > 0)
                            <span class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full"
                                x-show="!sidebarCollapsed" x-cloak>{{ $pendingCommentsCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.online-reports.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.online-reports.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Online Reports</span>
                    </a>
                </div>

                {{-- System --}}
                <div>
                    <p x-show="!sidebarCollapsed" x-cloak
                        class="px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">System</p>

                    <a href="{{ route('admin.settings.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Settings</span>
                    </a>

                    <a href="{{ route('admin.backups.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.backups.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6.75 4.5v6m3.75-6v6M4.5 7.5h15M9.75 7.5V3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V7.5" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-cloak>Backups</span>
                    </a>

                    @if (auth('admin')->user()->isSuperAdmin())
                        <a href="{{ route('admin.branches.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.branches.*') ? 'sidebar-link-active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-cloak>Branches</span>
                        </a>
                        <a href="{{ route('admin.admin-users.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.admin-users.*') ? 'sidebar-link-active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-3-3.87M7 10a4 4 0 100-8" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-cloak>Admin Users</span>
                        </a>
                    @endif
                </div>

            </nav>

            {{-- Collapse toggle (desktop only) --}}
            <button
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebar-collapsed', sidebarCollapsed)"
                class="hidden md:flex w-full items-center justify-center gap-2 py-3 border-t border-gray-800 text-gray-400 hover:text-white hover:bg-gray-800 transition">
                <svg class="w-4 h-4 transition-transform" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="text-xs">Collapse</span>
            </button>
        </aside>


        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <header class="bg-white shadow-sm px-4 md:px-6 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <button @click="mobileSidebarOpen = true" class="md:hidden text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-3" x-data="notificationDropdown()">
                    {{-- Notification Bell --}}
                    <div class="relative">
                        <button @click="toggle()" type="button"
                            class="relative p-2 rounded-full hover:bg-gray-100 transition" aria-label="Notifications">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span x-show="unreadCount > 0" x-cloak x-text="unreadCount"
                                class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"></span>
                        </button>

                        <div x-show="open" x-cloak @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 z-50 max-h-96 overflow-y-auto">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                                <h3 class="font-semibold text-sm">Notifications</h3>
                                <button @click="markAllRead()" class="text-xs text-brand hover:underline"
                                    x-show="unreadCount > 0">Mark all read</button>
                            </div>

                            <template x-if="notifications.length === 0">
                                <p class="text-sm text-gray-400 text-center py-8">কোনো নোটিফিকেশন নেই।</p>
                            </template>

                            <template x-for="n in notifications" :key="n.id">
                                <a :href="'{{ url('admin/notifications') }}/' + n.id + '/read'"
                                    class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition"
                                    :class="!n.is_read ? 'bg-blue-50/50' : ''">
                                    <div class="flex items-start gap-2">
                                        <span x-text="iconFor(n.type)" class="text-lg flex-shrink-0"></span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-800" x-text="n.title"></p>
                                            <p class="text-xs text-gray-500 mt-0.5" x-text="n.body"></p>
                                            <p class="text-xs text-gray-400 mt-1" x-text="timeAgo(n.created_at)"></p>
                                        </div>
                                    </div>
                                </a>
                            </template>

                            <div class="px-4 py-2 text-center border-t border-gray-100">
                                <a href="{{ route('admin.notifications.index') }}"
                                    class="text-xs text-brand hover:underline">View All Notifications</a>
                            </div>
                        </div>
                    </div>

                    <button id="admin-theme-toggle" type="button"
                        class="p-2 rounded-full hover:bg-gray-100 transition" aria-label="Toggle dark mode">
                        <svg id="admin-theme-icon-sun" class="w-5 h-5 text-gray-500 hidden" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg id="admin-theme-icon-moon" class="w-5 h-5 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                        <div
                            class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center text-xs font-semibold">
                            {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                        </div>
                        <div class="leading-tight">
                            <span class="block">{{ auth('admin')->user()->name }}</span>
                            <span class="block text-xs text-gray-400">{{ auth('admin')->user()->roleLabel() }}
                                @if (auth('admin')->user()->branch)
                                    · {{ auth('admin')->user()->branch->name }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="text-sm text-red-600 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-6 flex-1">
                @if (session('success'))
                    <div
                        class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">
                        {{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div
                        class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">
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

    <script>
        const adminThemeToggle = document.getElementById('admin-theme-toggle');
        const adminSunIcon = document.getElementById('admin-theme-icon-sun');
        const adminMoonIcon = document.getElementById('admin-theme-icon-moon');

        function updateAdminThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            if (adminSunIcon) adminSunIcon.classList.toggle('hidden', !isDark);
            if (adminMoonIcon) adminMoonIcon.classList.toggle('hidden', isDark);
        }
        updateAdminThemeIcon();

        if (adminThemeToggle) {
            adminThemeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
                updateAdminThemeIcon();
            });
        }

        function notificationDropdown() {
            return {
                open: false,
                notifications: [],
                unreadCount: 0,

                init() {
                    this.fetchNotifications();
                    setInterval(() => this.fetchNotifications(), 30000); // প্রতি ৩০ সেকেন্ডে পোল করবে
                },

                toggle() {
                    this.open = !this.open;
                    if (this.open) this.fetchNotifications();
                },

                fetchNotifications() {
                    fetch('{{ route('admin.notifications.recent') }}')
                        .then(res => res.json())
                        .then(data => {
                            this.notifications = data.notifications;
                            this.unreadCount = data.unread_count;
                        })
                        .catch(() => {});
                },

                markAllRead() {
                    fetch('{{ route('admin.notifications.mark-all-read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    }).then(() => {
                        this.unreadCount = 0;
                        this.notifications.forEach(n => n.is_read = true);
                    });
                },

                iconFor(type) {
                    return {
                        appointment: '📅',
                        message: '💬',
                        comment: '📝'
                    } [type] || '🔔';
                },

                timeAgo(dateStr) {
                    const seconds = Math.floor((new Date() - new Date(dateStr)) / 1000);
                    if (seconds < 60) return 'এইমাত্র';
                    const minutes = Math.floor(seconds / 60);
                    if (minutes < 60) return minutes +
                        ' মিনিট আগে';
                    const hours = Math.floor(minutes / 60);
                    if (hours < 24) return hours + ' ঘণ্টা আগে';
                    const
                        days = Math.floor(hours / 24);
                    return days + ' দিন আগে';
                },
            };
        }
    </script>

    @stack('scripts')

</body>

</html>
