@php($setting = \App\Models\Setting::get())

<div class="bg-brand text-white text-sm relative z-[60]">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
        <div class="flex items-center gap-4">
            @if ($setting->facebook_url)
                <a href="{{ $setting->facebook_url }}" target="_blank" class="hover:text-gray-200" aria-label="Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88v-6.99h-2.54V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99C18.34 21.13 22 16.99 22 12z" />
                    </svg>
                </a>
            @endif
            @if ($setting->twitter_url)
                <a href="{{ $setting->twitter_url }}" target="_blank" class="hover:text-gray-200" aria-label="Twitter">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 5.92c-.77.35-1.6.58-2.46.68a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04 4.28 4.28 0 0 0-7.29 3.9A12.15 12.15 0 0 1 2.9 4.9a4.28 4.28 0 0 0 1.32 5.71 4.25 4.25 0 0 1-1.94-.54v.05a4.28 4.28 0 0 0 3.43 4.2 4.3 4.3 0 0 1-1.93.07 4.29 4.29 0 0 0 4 2.98A8.59 8.59 0 0 1 2 18.58a12.12 12.12 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2 0-.19 0-.37-.01-.56A8.7 8.7 0 0 0 22 5.92z" />
                    </svg>
                </a>
            @endif
            @if ($setting->youtube_url)
                <a href="{{ $setting->youtube_url }}" target="_blank" class="hover:text-gray-200" aria-label="YouTube">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.5 6.2a3.02 3.02 0 0 0-2.12-2.14C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.38.56A3.02 3.02 0 0 0 .5 6.2 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.8 3.02 3.02 0 0 0 2.12 2.14C4.5 20.5 12 20.5 12 20.5s7.5 0 9.38-.56a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.8zM9.6 15.6V8.4L15.8 12l-6.2 3.6z" />
                    </svg>
                </a>
            @endif
        </div>

        <div class="flex items-center gap-4">
            @if ($setting->hotline)
                <a href="tel:{{ $setting->hotline }}" class="flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.517l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ $setting->hotline }}
                </a>
            @endif

            <div class="flex items-center gap-2 text-xs">
                <a href="{{ route('lang.switch', 'en') }}"
                    class="{{ app()->getLocale() == 'en' ? 'font-bold underline' : '' }}">EN</a>
                <span>|</span>
                <a href="{{ route('lang.switch', 'bn') }}"
                    class="{{ app()->getLocale() == 'bn' ? 'font-bold underline' : '' }}">বাংলা</a>
            </div>

            @if (auth('patient')->check())
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="text-xs flex items-center gap-1 hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ auth('patient')->user()->name }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition
                        class="absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded-md shadow-lg py-2 z-50">
                        <a href="{{ route('patient.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">📊
                            My Account</a>
                        <a href="{{ route('patient.appointments') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50">📅 My Appointments</a>
                        <a href="{{ route('patient.reports') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">📄 My
                            Reports</a>
                        <form action="{{ route('patient.logout') }}" method="POST"
                            class="border-t border-gray-100 mt-1">
                            @csrf
                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('patient.login') }}" class="text-xs hover:text-gray-200">Patient Login</a>
            @endif

            <button id="theme-toggle" type="button" class="p-1.5 rounded-full hover:bg-white/10 transition"
                aria-label="Toggle dark mode">
                <svg id="theme-icon-sun" class="w-4 h-4 hidden" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg id="theme-icon-moon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
    </div>
</div>
