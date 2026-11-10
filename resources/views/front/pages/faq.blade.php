@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <section class="max-w-3xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Frequently Asked Questions</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-10">সাধারণ জিজ্ঞাসা ও উত্তর</p>

        @forelse($faqs as $category => $items)
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4 text-brand">{{ $category }}</h2>
                <div class="space-y-3">
                    @foreach ($items as $faq)
                        <div x-data="{ open: false }" class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-5 py-4 text-left">
                                <span class="font-medium text-sm">{{ $faq->question }}</span>
                                <svg class="w-4 h-4 flex-shrink-0 text-gray-400 transition-transform duration-300"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-collapse x-cloak
                                class="px-5 pb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-16">কোনো প্রশ্ন যোগ করা হয়নি।</p>
        @endforelse
    </section>
@endsection
