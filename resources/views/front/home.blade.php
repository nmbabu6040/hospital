@extends('layouts.app')

@section('title', 'Home')
@section('meta_description',
    'Labaid Clone Hospital - Leading multi-disciplinary hospital with expert doctors and modern
    facilities.')

@section('content')

    {{-- Hero Slider --}}
    <section class="relative h-[420px] md:h-[520px] overflow-hidden bg-gray-800">
        @forelse($sliders as $i => $slider)
            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $i !== 0 ? 'opacity-0' : '' }}">
                <img src="{{ $slider->image ? asset('storage/' . $slider->image) : 'https://placehold.co/1600x600/0e4d92/ffffff?text=Labaid+Clone+Hospital' }}"
                    alt="{{ $slider->title }}" class="w-full h-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-black/40 flex items-center">
                    <div class="max-w-7xl mx-20 px-4 text-white">
                        @if ($slider->title)
                            <h1 class="text-3xl md:text-5xl font-bold mb-3">{{ $slider->title }}</h1>
                        @endif
                        @if ($slider->subtitle)
                            <p class="text-lg md:text-xl mb-2 max-w-xl">{{ $slider->subtitle }}</p>
                        @endif
                        @if ($slider->description)
                            <p class="text-sm md:text-base mb-5 max-w-xl text-gray-200">{{ $slider->description }}</p>
                        @endif
                        <div class="flex flex-wrap gap-3 mt-4">
                            @if ($slider->cta_text && $slider->cta_url)
                                <a href="{{ Str::startsWith($slider->cta_url, ['http://', 'https://']) ? $slider->cta_url : url($slider->cta_url) }}"
                                    class="btn-primary">{{ $slider->cta_text }}</a>
                            @endif
                            @if ($slider->cta_text_2 && $slider->cta_url_2)
                                <a href="{{ Str::startsWith($slider->cta_url_2, ['http://', 'https://']) ? $slider->cta_url_2 : url($slider->cta_url_2) }}"
                                    class="inline-block border border-white text-white px-5 py-2.5 rounded-md font-medium hover:bg-white hover:text-brand transition">{{ $slider->cta_text_2 }}</a>
                            @endif
                            @if (!$slider->cta_text)
                                <a href="{{ route('appointment.create') }}"
                                    class="btn-primary">{{ __('site.book_appointment') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="hero-slide absolute inset-0">
                <img src="https://placehold.co/1600x600/0e4d92/ffffff?text=Labaid+Clone+Hospital"
                    class="w-full h-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-black/40 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 text-white">
                        <h1 class="text-3xl md:text-5xl font-bold mb-3">Your Health, Our Priority</h1>
                        <a href="{{ route('appointment.create') }}"
                            class="btn-primary">{{ __('site.book_appointment') }}</a>
                    </div>
                </div>
            </div>
        @endforelse
    </section>

    {{-- Quick Search --}}
    <section class="max-w-4xl mx-auto px-4 -mt-10 relative z-10">
        <form action="{{ route('search.index') }}" method="GET"
            class="bg-white rounded-lg shadow-lg p-4 flex flex-col md:flex-row gap-3">
            <input type="text" name="q" placeholder="{{ __('site.search_placeholder') }}"
                class="flex-1 border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </section>

    {{-- Hospital / Diagnostic Tabs --}}
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div x-data="{ tab: 'hospital' }">
            <div class="flex justify-center gap-4 mb-8" x-data>
                <button
                    onclick="document.getElementById('tab-hospital').classList.remove('hidden'); document.getElementById('tab-diagnostic').classList.add('hidden');"
                    class="px-6 py-2 rounded-full border border-brand text-brand font-medium hover:bg-brand hover:text-white transition">
                    {{ __('site.our_hospitals') }}
                </button>
                <button
                    onclick="document.getElementById('tab-diagnostic').classList.remove('hidden'); document.getElementById('tab-hospital').classList.add('hidden');"
                    class="px-6 py-2 rounded-full border border-brand text-brand font-medium hover:bg-brand hover:text-white transition">
                    {{ __('site.our_diagnostics') }}
                </button>
            </div>

            <div id="tab-hospital" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($hospitals as $hospital)
                    <a href="{{ route('hospitals.show', $hospital) }}" class="card">
                        <img src="{{ $hospital->image ? asset('storage/' . $hospital->image) : 'https://placehold.co/400x250?text=' . urlencode($hospital->name) }}"
                            class="w-full h-48 object-cover" loading="lazy" alt="{{ $hospital->name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $hospital->name }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($hospital->address, 60) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div id="tab-diagnostic" class="hidden grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($diagnostics as $diagnostic)
                    <a href="{{ route('diagnostics.show', $diagnostic) }}" class="card">
                        <img src="{{ $diagnostic->image ? asset('storage/' . $diagnostic->image) : 'https://placehold.co/400x250?text=' . urlencode($diagnostic->name) }}"
                            class="w-full h-48 object-cover" loading="lazy" alt="{{ $diagnostic->name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $diagnostic->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($diagnostic->address, 60) }}
                            </p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-10">No diagnostic centers found.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Accreditation --}}
    @if ($accreditations->count())
        <section class="bg-white py-14">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="section-title">{{ __('site.accreditation') }}</h2>
                <div class="flex justify-center items-center gap-10">
                    @foreach ($accreditations as $accreditation)
                        <div>
                            <img src="{{ $accreditation->logo ? asset('storage/' . $accreditation->logo) : 'https://placehold.co/160x100?text=' . urlencode($accreditation->name) }}"
                                alt="{{ $accreditation->name }}" class="h-30" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Google Rating --}}
    @if ($aboutContent && \App\Models\Setting::get()->google_rating)
        @php($googleSetting = \App\Models\Setting::get())
        <section class="py-10">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="inline-flex items-center gap-4 bg-white rounded-xl shadow-sm px-6 py-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" class="w-10 h-10"
                        alt="Google">
                    <div class="text-left">
                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($googleSetting->google_rating) ? 'text-amber-400' : 'text-gray-200' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endfor
                            <span class="font-bold ml-1">{{ $googleSetting->google_rating }}</span>
                        </div>
                        <p class="text-xs text-gray-500">
                            Based on {{ number_format($googleSetting->google_review_count) }} reviews
                            @if ($googleSetting->google_business_profile_url)
                                · <a href="{{ $googleSetting->google_business_profile_url }}" target="_blank"
                                    class="text-brand hover:underline">View on Google</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- About + Stats --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ __('site.about_us') }}</h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $aboutContent->about_text ? Str::limit($aboutContent->about_text, 220) : 'আমরা আধুনিক চিকিৎসা প্রযুক্তি ও অভিজ্ঞ বিশেষজ্ঞ ডাক্তারদের সমন্বয়ে সর্বোচ্চ মানের স্বাস্থ্যসেবা প্রদান করে আসছি।' }}
                </p>
                <a href="{{ route('about.about-us') }}" class="btn-outline">{{ __('site.read_more') }}</a>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->patients_count ?: 50000) }}+
                    </p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.patients') }}</p>
                </div>
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->staff_count ?: 1200) }}+</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.staff') }}</p>
                </div>
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->doctors_count ?: 300) }}+</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.expert_doctors') }}</p>
                </div>
            </div>
        </div>
    </section>


    {{-- Major Departments --}}
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="section-title">{{ __('site.major_departments') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($departments as $department)
                    <a href="{{ route('departments.show', $department) }}" class="card p-5 text-center group">
                        <div
                            class="w-14 h-14 mx-auto mb-3 rounded-full bg-brand/10 flex items-center justify-center group-hover:bg-brand transition">
                            <svg class="w-7 h-7 text-brand group-hover:text-white transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                        </div>
                        <h3 class="font-medium text-sm">{{ $department->name }}</h3>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('departments.index') }}" class="btn-outline">{{ __('site.view_all') }}</a>
            </div>
        </div>
    </section>

    {{-- Doctor's Talk --}}
    @if ($featuredVideo)
        <section id="doctors-talk" class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="section-title">{{ __('site.doctors_talk') }}</h2>
                <div class="aspect-video max-w-3xl mx-auto rounded-lg overflow-hidden shadow-lg">
                    <iframe class="w-full h-full" src="{{ $featuredVideo->youtube_url }}"
                        title="{{ $featuredVideo->title }}" frameborder="0" allowfullscreen loading="lazy"></iframe>
                </div>
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm mt-3">{{ $featuredVideo->title }}</p>
            </div>
        </section>
    @endif

    {{-- Our Doctors Carousel --}}
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="section-title">{{ __('site.our_doctors') }}</h2>
            <div class="flex gap-5 overflow-x-auto pb-4 snap-x">
                @foreach ($doctors as $doctor)
                    <a href="{{ route('doctors.show', $doctor) }}" class="card min-w-[220px] snap-start">
                        <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/300x300?text=' . urlencode($doctor->name) }}"
                            class="w-full h-56 object-cover" loading="lazy" alt="{{ $doctor->name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-sm">{{ $doctor->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $doctor->designation }}</p>
                            <p class="text-xs text-brand mt-1">{{ $doctor->department?->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('doctors.index') }}" class="btn-outline">{{ __('site.view_all') }}</a>
            </div>
        </div>
    </section>

    {{-- Latest News --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="section-title">{{ __('site.latest_news') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ($news as $item)
                    <a href="{{ route('news.show', $item) }}" class="card">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/300x200?text=News' }}"
                            class="w-full h-40 object-cover" loading="lazy" alt="{{ $item->title }}">
                        <div class="p-4">
                            <p class="text-xs text-gray-400 mb-1">{{ $item->published_at?->format('d M, Y') }}</p>
                            <h3 class="font-medium text-sm">{{ Str::limit($item->title, 60) }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('news.index') }}" class="btn-outline">{{ __('site.view_all') }}</a>
            </div>
        </div>
    </section>

    {{-- Sister Concerns --}}
    @if ($sisterConcerns->count())
        <section class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="section-title">{{ __('site.sister_concerns') }}</h2>
                <div class="flex justify-center items-center gap-5">
                    @foreach ($sisterConcerns as $sc)
                        <a href="{{ $sc->website_url ?? '#' }}" target="_blank"
                            class="opacity-70 hover:opacity-100 transition">
                            <img src="{{ $sc->logo ? asset('storage/' . $sc->logo) : 'https://placehold.co/150x80?text=' . urlencode($sc->name) }}"
                                class="h-40" loading="lazy" alt="{{ $sc->name }}">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
