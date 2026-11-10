@extends('layouts.app')

@section('title', $doctor->meta_title ?: $doctor->name)
@section('meta_description', $doctor->meta_description ?: Str::limit(strip_tags($doctor->bio), 150))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden md:flex">
            <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/400x400?text=' . urlencode($doctor->name) }}"
                class="w-full md:w-80 h-80 object-cover" loading="lazy" alt="{{ $doctor->name }}">

            <div class="p-6 flex-1">
                <h1 class="text-2xl font-bold">{{ $doctor->name }}</h1>
                <p class="text-brand font-medium mt-1">{{ $doctor->designation }}</p>
                <p class="text-gray-600 mt-1">{{ $doctor->degree }}</p>

                @if ($doctor->reviewCount() > 0)
                    <div class="flex items-center gap-2 mt-3">
                        @include('partials.star-rating', ['rating' => $doctor->averageRating()])
                        <span class="text-sm font-semibold">{{ $doctor->averageRating() }}</span>
                        <span class="text-sm text-gray-400">({{ $doctor->reviewCount() }} reviews)</span>
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-3">এখনো কোনো রিভিউ নেই — প্রথম রিভিউ দিন!</p>
                @endif

                <div class="mt-4 space-y-2 text-sm text-gray-700">
                    <p><strong>Department:</strong> {{ $doctor->department?->name }}</p>
                    <p><strong>Hospital:</strong> {{ $doctor->hospital?->name }}</p>
                    <p><strong>Chamber Time:</strong> {{ $doctor->chamber_time }}</p>
                </div>

                @if ($doctor->bio)
                    <p class="text-gray-600 mt-4 leading-relaxed">{{ $doctor->bio }}</p>
                @endif

                <div class="flex flex-wrap items-center gap-4 mt-6">
                    <a href="{{ route('appointment.create', ['doctor' => $doctor->id]) }}" class="btn-primary">
                        {{ __('site.book_appointment') }}
                    </a>
                    @include('partials.social-share', ['title' => $doctor->name])
                </div>
            </div>
        </div>

        {{-- Rating Breakdown --}}
        @if ($doctor->reviewCount() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                <h2 class="font-semibold text-lg mb-4">Rating Breakdown</h2>
                <div class="space-y-2">
                    @foreach ([5, 4, 3, 2, 1] as $star)
                        @php($count = $ratingBreakdown[$star] ?? 0)
                        @php($percent = $doctor->reviewCount() > 0 ? ($count / $doctor->reviewCount()) * 100 : 0)
                        <div class="flex items-center gap-3 text-sm">
                            <span class="w-12 text-gray-500">{{ $star }} star</span>
                            <div class="flex-1 bg-gray-100 rounded-full h-2">
                                <div class="bg-amber-400 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-8 text-gray-400 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Reviews List --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-6">Patient Reviews ({{ $doctor->reviewCount() }})</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4 mb-8">
                @forelse($reviews as $review)
                    <div class="bg-white rounded-lg shadow-sm p-5">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-brand text-white flex items-center justify-center text-sm font-semibold">
                                    {{ strtoupper(substr($review->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-sm">{{ $review->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @include('partials.star-rating', ['rating' => $review->rating])
                        </div>
                        @if ($review->review)
                            <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $review->review }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">এখনো কোনো রিভিউ নেই।</p>
                @endforelse
            </div>

            <div class="mb-8">{{ $reviews->links() }}</div>

            {{-- Review Form --}}
            <div class="bg-white rounded-lg shadow-sm p-6" x-data="{ rating: 0, hoverRating: 0 }">
                <h3 class="font-semibold mb-4">একটি রিভিউ লিখুন</h3>

                <form action="{{ route('doctor-reviews.store', $doctor) }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label>Website</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">আপনার রেটিং *</label>
                        <div class="flex gap-1">
                            <template x-for="star in [1,2,3,4,5]" :key="star">
                                <button type="button" @click="rating = star" @mouseenter="hoverRating = star"
                                    @mouseleave="hoverRating = 0">
                                    <svg class="w-7 h-7 transition"
                                        :class="(hoverRating || rating) >= star ? 'text-amber-400' : 'text-gray-200'"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="rating" :value="rating" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="আপনার নাম *" required
                            value="{{ old('name', auth('patient')->user()->name ?? '') }}"
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
                        <input type="email" name="email" placeholder="আপনার ইমেইল *" required
                            value="{{ old('email', auth('patient')->user()->email ?? '') }}"
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
                    </div>

                    <textarea name="review" rows="3" placeholder="আপনার অভিজ্ঞতা লিখুন (ঐচ্ছিক)..."
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">{{ old('review') }}</textarea>

                    <button type="submit" :disabled="rating === 0"
                        :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : ''" class="btn-primary text-sm">Submit
                        Review</button>
                </form>
            </div>
        </div>

    </section>
@endsection
