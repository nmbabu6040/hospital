<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php($seoSetting = \App\Models\Setting::get())
    <title>@yield('title', 'Hospital') @if ($seoSetting->site_meta_title_suffix)
            {{ $seoSetting->site_meta_title_suffix }}
        @else
            | {{ config('app.name') }}
        @endif
    </title>
    <meta name="description" content="@yield('meta_description', $seoSetting->default_meta_description ?: 'Leading multi-disciplinary hospital providing world-class healthcare services.')">

    {{-- Open Graph tags --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', $seoSetting->default_meta_description ?: 'Leading multi-disciplinary hospital providing world-class healthcare services.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($seoSetting->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $seoSetting->og_image) }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    @php($globalSetting = \App\Models\Setting::get())
    @if ($globalSetting->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $globalSetting->favicon) }}">
    @endif


    {{-- Dark mode flash রোধ করার জন্য এই script সবার আগে থাকবে --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php($themeSetting = \App\Models\Setting::get())
    <style>
        :root {
            --color-brand: {{ $themeSetting->themePrimaryColor() }};
            --color-brand-dark: {{ $themeSetting->themePrimaryDarkColor() }};
            --font-sans: '{{ $themeSetting->themeFont() }}', 'Hind Siliguri', sans-serif;
        }
    </style>
    @if (!in_array($themeSetting->themeFont(), ['Poppins', 'Hind Siliguri']))
        <link
            href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $themeSetting->themeFont()) }}:wght@400;500;600;700&display=swap"
            rel="stylesheet">
    @endif

    @if ($seoSetting->google_site_verification)
        <meta name="google-site-verification" content="{{ $seoSetting->google_site_verification }}">
    @endif

    {{-- Google Tag Manager (head) --}}
    @if ($seoSetting->google_tag_manager_id)
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $seoSetting->google_tag_manager_id }}');
        </script>
    @endif

    {{-- Google Analytics (GA4) --}}
    @if ($seoSetting->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSetting->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $seoSetting->google_analytics_id }}');
        </script>
    @endif

    {{-- Facebook Pixel --}}
    @if ($seoSetting->facebook_pixel_id)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $seoSetting->facebook_pixel_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $seoSetting->facebook_pixel_id }}&ev=PageView&noscript=1" />
        </noscript>
    @endif

    {{-- Custom Head Scripts --}}
    @if ($seoSetting->custom_head_scripts)
        {!! $seoSetting->custom_head_scripts !!}
    @endif
</head>

<body class="bg-gray-50 text-gray-800 transition-colors duration-300">

    {{-- Google Tag Manager (noscript) --}}
    @if ($seoSetting->google_tag_manager_id)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $seoSetting->google_tag_manager_id }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('partials.topbar')
    @include('partials.header')

    <main>
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div
                    class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Floating Buttons --}}
    @php($setting = \App\Models\Setting::get())

    @if ($setting->whatsapp_number)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp_number) }}" target="_blank"
            class="floating-btn bg-green-500 hover:bg-green-600 bottom-6 right-6" aria-label="WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.82L2 22l5.4-1.42a9.87 9.87 0 004.64 1.18h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.83 14.07c-.25.69-1.24 1.27-1.95 1.42-.5.1-1.15.19-3.33-.71-2.79-1.15-4.59-3.99-4.73-4.17-.14-.19-1.13-1.5-1.13-2.86 0-1.37.7-2.03.95-2.31.25-.28.54-.35.72-.35.18 0 .36 0 .51.01.17.01.38-.06.6.46.22.53.76 1.84.82 1.97.07.14.11.3.02.49-.09.19-.14.3-.27.46-.14.17-.29.37-.41.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.17-.19.69-.8.88-1.08.19-.28.37-.23.63-.14.25.09 1.6.76 1.88.9.28.14.46.21.53.33.07.12.07.68-.18 1.36z" />
            </svg>
        </a>
    @endif

    <button id="scroll-top-btn"
        class="floating-btn bg-brand hover:bg-brand-dark bottom-24 right-6 opacity-0 translate-y-3 pointer-events-none"
        aria-label="Scroll to top">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Hero slider
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;
        if (slides.length > 1) {
            setInterval(() => {
                slides[currentSlide].classList.add('opacity-0');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.remove('opacity-0');
            }, 4000);
        }

        // Dark mode toggle
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-icon-sun');
        const moonIcon = document.getElementById('theme-icon-moon');

        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            if (sunIcon) sunIcon.classList.toggle('hidden', !isDark);
            if (moonIcon) moonIcon.classList.toggle('hidden', isDark);
        }
        updateThemeIcon();

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeIcon();
            });
        }

        // Scroll to top button
        const scrollBtn = document.getElementById('scroll-top-btn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('opacity-0', 'translate-y-3', 'pointer-events-none');
            } else {
                scrollBtn.classList.add('opacity-0', 'translate-y-3', 'pointer-events-none');
            }
        });
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
