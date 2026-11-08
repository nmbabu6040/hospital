<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between py-4">

            <a href="{{ route('home') }}" class="flex items-center gap-2">
                @php($setting = \App\Models\Setting::get())
                @if ($setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ config('app.name') }}" class="h-12">
                @else
                    <span class="text-2xl font-bold text-brand">Labaid<span class="text-gray-700">Clone</span></span>
                @endif
            </a>

            <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-brand">{{ __('site.home') }}</a>

                <div class="relative group">
                    <button class="hover:text-brand flex items-center gap-1">
                        {{ __('site.about_us') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 w-56 top-full left-0">
                        <a href="{{ route('about.md-message') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.md_message') }}</a>
                        <a href="{{ route('about.about-us') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.about') }}</a>
                        <a href="{{ route('about.accreditation') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.accreditation') }}</a>
                        <a href="{{ route('about.sister-concerns') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.sister_concerns') }}</a>
                    </div>
                </div>

                <a href="{{ route('doctors.index') }}" class="hover:text-brand">{{ __('site.doctors') }}</a>
                <a href="{{ route('departments.index') }}" class="hover:text-brand">{{ __('site.departments') }}</a>
                <a href="{{ route('hospitals.index') }}" class="hover:text-brand">{{ __('site.hospitals') }}</a>

                <a href="{{ route('locations.index') }}" class="hover:text-brand">Locations</a>

                <a href="{{ route('diagnostics.index') }}" class="hover:text-brand">{{ __('site.diagnostics') }}</a>

                <div class="relative group">
                    <button class="hover:text-brand flex items-center gap-1">
                        {{ __('site.media') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 w-48 top-full left-0">
                        <a href="{{ route('news.index') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.news') }}</a>
                        <a href="{{ route('gallery.index') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.gallery') }}</a>
                        <a href="{{ route('offers.index') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.offers') }}</a>
                        <a href="{{ route('home') }}#doctors-talk"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.doctors_talk') }}</a>
                        <a href="{{ route('journals.index') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.journal') }}</a>
                        <a href="{{ route('videos.index') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.videos') }}</a>
                        <a href="{{ route('about.md-message') }}"
                            class="block px-4 py-2 hover:bg-gray-50">{{ __('site.md_write_up') }}</a>
                    </div>
                </div>

                @php($headerPages = \App\Models\Page::where('is_active', true)->where('show_in_menu', true)->where('menu_location', 'header')->orderBy('sort_order')->get())
                @foreach ($headerPages as $headerPage)
                    <a href="{{ route('pages.show', $headerPage) }}"
                        class="hover:text-brand">{{ $headerPage->title }}</a>
                @endforeach

                <a href="{{ route('contact.index') }}" class="hover:text-brand">{{ __('site.contact_us') }}</a>


            </nav>


            <div class="relative hidden lg:block" x-data="globalSearch()">
                <button @click="open = !open; open && $nextTick(() => $refs.searchInput.focus())"
                    class="p-2 text-gray-500 hover:text-brand" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <div x-show="open" x-cloak @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-100 dark:border-gray-800 z-50 p-3">
                    <form action="{{ route('search.index') }}" method="GET" @submit="open = false">
                        <input x-ref="searchInput" type="text" name="q" x-model="query"
                            @input.debounce.400ms="search()" placeholder="Search doctors, packages, news..."
                            class="w-full border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
                    </form>

                    <div x-show="results.length > 0" class="mt-2 max-h-80 overflow-y-auto space-y-1">
                        <template x-for="result in results" :key="result.url">
                            <a :href="result.url"
                                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="text-lg" x-text="result.icon"></span>
                                <div class="min-w-0">
                                    <p class="text-xs text-brand font-medium" x-text="result.type"></p>
                                    <p class="text-sm text-gray-800 dark:text-gray-100 truncate"
                                        x-text="result.title"></p>
                                </div>
                            </a>
                        </template>
                    </div>

                    <template x-if="query.length >= 2 && results.length === 0 && !loading">
                        <p class="text-sm text-gray-400 text-center py-4">কোনো ফলাফল পাওয়া যায়নি।</p>
                    </template>
                </div>
            </div>

            <button id="mobile-menu-btn" class="lg:hidden p-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <button id="mobile-menu-btn" class="lg:hidden p-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4 space-y-2 text-sm font-medium text-gray-700">
            <form action="{{ route('search.index') }}" method="GET" class="pb-3 border-b">
                <input type="text" name="q" placeholder="Search..."
                    class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
            </form>
            <a href="{{ route('home') }}" class="block py-2 border-b">{{ __('site.home') }}</a>
            <a href="{{ route('about.md-message') }}" class="block py-2 border-b">{{ __('site.md_message') }}</a>
            <a href="{{ route('about.about-us') }}" class="block py-2 border-b">{{ __('site.about') }}</a>
            <a href="{{ route('about.accreditation') }}"
                class="block py-2 border-b">{{ __('site.accreditation') }}</a>
            <a href="{{ route('about.sister-concerns') }}"
                class="block py-2 border-b">{{ __('site.sister_concerns') }}</a>
            <a href="{{ route('doctors.index') }}" class="block py-2 border-b">{{ __('site.doctors') }}</a>
            <a href="{{ route('departments.index') }}" class="block py-2 border-b">{{ __('site.departments') }}</a>
            <a href="{{ route('hospitals.index') }}" class="block py-2 border-b">{{ __('site.hospitals') }}</a>
            <a href="{{ route('diagnostics.index') }}" class="block py-2 border-b">{{ __('site.diagnostics') }}</a>
            <a href="{{ route('news.index') }}" class="block py-2 border-b">{{ __('site.news') }}</a>
            <a href="{{ route('gallery.index') }}" class="block py-2 border-b">{{ __('site.gallery') }}</a>
            <a href="{{ route('offers.index') }}" class="block py-2 border-b">{{ __('site.offers') }}</a>

            <a href="{{ route('videos.index') }}" class="block py-2 border-b">{{ __('site.videos') }}</a>
            <a href="{{ route('journals.index') }}" class="block py-2 border-b">{{ __('site.journal') }}</a>

            @foreach ($headerPages as $headerPage)
                <a href="{{ route('pages.show', $headerPage) }}"
                    class="block py-2 border-b">{{ $headerPage->title }}</a>
            @endforeach

            <a href="{{ route('contact.index') }}" class="block py-2">{{ __('site.contact_us') }}</a>

        </div>

        <!-- Action Buttons -->
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2 pb-4">
            <a href="{{ route('appointment.create') }}"
                class="flex-1 min-w-[140px] text-center bg-brand text-white py-2.5 px-3 rounded-md text-sm font-medium hover:bg-brand-dark transition">
                {{ __('site.book_appointment') }}
            </a>
            <a href="{{ route('online-report.index') }}"
                class="flex-1 min-w-[140px] text-center bg-gray-100 text-gray-800 py-2.5 px-3 rounded-md text-sm font-medium hover:bg-gray-200 transition">
                {{ __('site.online_report') }}
            </a>
            <a href="{{ route('packages.index') }}"
                class="flex-1 min-w-[140px] text-center bg-gray-100 text-gray-800 py-2.5 px-3 rounded-md text-sm font-medium hover:bg-gray-200 transition">
                {{ __('site.packages_vaccines') }}
            </a>
            <a href="{{ route('ambulance.create') }}"
                class="flex-1 min-w-[140px] text-center bg-red-500 text-white py-2.5 px-3 rounded-md text-sm font-medium hover:bg-red-600 transition">
                🚑 Ambulance
            </a>

            <div class="relative flex-1 min-w-[140px]" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false"
                    class="w-full text-center bg-gray-100 text-gray-800 py-2.5 px-3 rounded-md text-sm font-medium hover:bg-gray-200 transition flex items-center justify-center gap-1">
                    More Services
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak x-transition
                    class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-900 rounded-md shadow-lg border border-gray-100 dark:border-gray-800 py-2 z-40">
                    <a href="{{ route('video-consultation.create') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">📹 Video
                        Consultation</a>
                    <a href="{{ route('blood-bank.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">🩸 Blood Bank</a>
                    <a href="{{ route('locations.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">📍 Our Locations</a>
                    <a href="{{ route('beds.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">🛏️ Bed
                        Availability</a>
                    <a href="{{ route('queue.index') }}" target="_blank"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">📺 Live Queue</a>
                    <a href="{{ route('pharmacy.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-800">💊 Pharmacy</a>
                </div>
            </div>
        </div>
    </div>
</header>
