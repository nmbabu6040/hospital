@extends('layouts.app')

@section('title', $query ? 'Search: ' . $query : 'Search')

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-10">
        <form action="{{ route('search.index') }}" method="GET" class="mb-8">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}"
                    placeholder="Search doctors, departments, hospitals, packages, tests, news..."
                    class="w-full border border-gray-200 rounded-full pl-5 pr-14 py-4 text-base focus:outline-none focus:ring-2 focus:ring-brand">
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-brand text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        @if ($query)
            <p class="text-sm text-gray-500 mb-6">
                @if (count($results) > 0)
                    "<strong>{{ $query }}</strong>" এর জন্য {{ count($results) }}টি ফলাফল পাওয়া গেছে
                @else
                    "<strong>{{ $query }}</strong>" এর জন্য কোনো ফলাফল পাওয়া যায়নি
                @endif
            </p>
        @endif

        @if (count($results) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($results as $result)
                    <a href="{{ $result['url'] }}" class="card p-4 flex items-start gap-3 hover:shadow-md transition">
                        <span class="text-2xl flex-shrink-0">{{ $result['icon'] }}</span>
                        <div class="min-w-0">
                            <span class="text-xs text-brand font-medium uppercase">{{ $result['type'] }}</span>
                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-100 mt-0.5">{{ $result['title'] }}
                            </p>
                            @if ($result['subtitle'])
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $result['subtitle'] }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @elseif($query)
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-400">ভিন্ন কোনো শব্দ দিয়ে আবার চেষ্টা করুন, অথবা <a
                        href="{{ route('contact.index') }}" class="text-brand hover:underline">আমাদের সাথে যোগাযোগ
                        করুন</a>।</p>
            </div>
        @endif
    </section>
@endsection
