@extends('layouts.app')

@section('title', 'Page Expired')

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-24 text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
            <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-3">419</h1>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-3">পেজের মেয়াদ শেষ হয়ে গেছে</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">দীর্ঘ সময় ধরে পেজটি খোলা থাকায় সেশনের মেয়াদ শেষ হয়ে গেছে।
            অনুগ্রহ করে পেজটি রিফ্রেশ করে আবার চেষ্টা করুন।</p>
        <a href="javascript:history.back()" class="btn-primary">পেছনে যান</a>
    </section>
@endsection
