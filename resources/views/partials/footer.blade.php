@php($setting = \App\Models\Setting::get())

<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

        <div>
            @if ($setting->footer_logo)
                <img src="{{ asset('storage/' . $setting->footer_logo) }}" alt="{{ config('app.name') }}"
                    class="h-12 mb-4">
            @else
                <h3 class="text-white text-lg font-semibold mb-4">{{ config('app.name') }}</h3>
            @endif
            <p class="text-sm leading-relaxed mb-3">{{ $setting->address }}</p>
            @if ($setting->hotline)
                <p class="text-sm mb-1">📞 {{ $setting->hotline }}</p>
            @endif
            @if ($setting->email)
                <p class="text-sm">✉️ {{ $setting->email }}</p>
            @endif


            <ul class="flex items-center gap-3 mt-5">

                @if ($setting->facebook_url)
                    <li>
                        <a href="{{ $setting->facebook_url }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                @endif

                @if ($setting->twitter_url)
                    <li>
                        <a href="{{ $setting->twitter_url }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Twitter"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-sky-500 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                @endif

                @if ($setting->youtube_url)
                    <li>
                        <a href="{{ $setting->youtube_url }}" target="_blank" rel="noopener noreferrer"
                            aria-label="YouTube"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-red-600 transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                @endif

            </ul>

        </div>

        <div>
            <h3 class="text-white text-lg font-semibold mb-4">{{ __('site.useful_links') }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('doctors.index') }}" class="hover:text-white">{{ __('site.doctors') }}</a></li>
                <li><a href="{{ route('departments.index') }}"
                        class="hover:text-white">{{ __('site.departments') }}</a></li>
                <li><a href="{{ route('hospitals.index') }}" class="hover:text-white">{{ __('site.hospitals') }}</a>
                </li>
                <li><a href="{{ route('packages.index') }}"
                        class="hover:text-white">{{ __('site.packages_vaccines') }}</a></li>
                <li><a href="{{ route('appointment.create') }}"
                        class="hover:text-white">{{ __('site.book_appointment') }}</a></li>
                <li><a href="{{ route('contact.index') }}" class="hover:text-white">{{ __('site.contact_us') }}</a>
                </li>
                @php($footerPages = \App\Models\Page::where('is_active', true)->where('show_in_menu', true)->where('menu_location', 'footer')->orderBy('sort_order')->get())
                @foreach ($footerPages as $footerPage)
                    <li><a href="{{ route('pages.show', $footerPage) }}"
                            class="hover:text-white">{{ $footerPage->title }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-white text-lg font-semibold mb-4">{{ __('site.media') }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('news.index') }}" class="hover:text-white">{{ __('site.news') }}</a></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-white">{{ __('site.gallery') }}</a></li>
                <li><a href="{{ route('offers.index') }}" class="hover:text-white">{{ __('site.offers') }}</a></li>
                <li><a href="{{ route('videos.index') }}" class="hover:text-white">{{ __('site.videos') }}</a></li>
                <li><a href="{{ route('journals.index') }}" class="hover:text-white">{{ __('site.journal') }}</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white text-lg font-semibold mb-4">{{ __('site.address') }}</h3>
            @if ($setting->google_map_embed)
                <div class="rounded-md overflow-hidden [&_iframe]:w-full [&_iframe]:h-[150px]">
                    {!! $setting->google_map_embed !!}
                </div>
            @else
                <p class="text-sm text-gray-500">Map not configured yet.</p>
            @endif
        </div>
    </div>

    <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-400">
        {{ $setting->footer_text ?? '© ' . date('Y') . ' ' . config('app.name') . '. ' . __('site.all_rights_reserved') . '.' }}
    </div>
</footer>
