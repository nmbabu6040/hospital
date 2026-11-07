@extends('layouts.app')

@section('title', $news->meta_title ?: $news->title)
@section('meta_description', $news->meta_description ?: Str::limit(strip_tags($news->content), 150))

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-10">
        <img src="{{ $news->image ? asset('storage/' . $news->image) : 'https://placehold.co/800x400?text=News' }}"
            class="w-full h-80 object-cover rounded-lg mb-6" loading="lazy" alt="{{ $news->title }}">

        <p class="text-sm text-gray-400 mb-2">{{ $news->published_at?->format('d M, Y') }}</p>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold">{{ $news->title }}</h1>
            @include('partials.social-share', ['title' => $news->title])
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed bg-white rounded-lg shadow-sm p-6">
            {{ $news->content }}
        </div>

        @if ($related->count())
            <h2 class="text-xl font-bold mt-12 mb-6">Related News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <a href="{{ route('news.show', $item) }}" class="card">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/400x250?text=News' }}"
                            class="w-full h-32 object-cover" loading="lazy" alt="{{ $item->title }}">
                        <div class="p-4">
                            <h3 class="font-medium text-sm">{{ Str::limit($item->title, 50) }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
    {{-- Comments Section --}}
    <section class="max-w-4xl mx-auto px-4 mt-12">
        <h2 class="text-xl font-bold mb-6">মন্তব্য ({{ $comments->count() }})</h2>

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 text-sm dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Comment List --}}
        <div class="space-y-5 mb-10">
            @forelse($comments as $comment)
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-brand text-white flex items-center justify-center text-sm font-semibold flex-shrink-0">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $comment->name }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <button type="button"
                            onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
                            class="text-xs text-brand hover:underline">Reply</button>
                    </div>

                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-3 leading-relaxed">{{ $comment->body }}</p>

                    {{-- Reply Form (hidden by default) --}}
                    <div id="reply-form-{{ $comment->id }}"
                        class="hidden mt-4 pl-4 border-l-2 border-gray-100 dark:border-gray-800">
                        @include('front.news._comment-form', ['parentId' => $comment->id])
                    </div>

                    {{-- Replies --}}
                    @if ($comment->replies->count())
                        <div class="mt-4 pl-4 border-l-2 border-gray-100 dark:border-gray-800 space-y-4">
                            @foreach ($comment->replies as $reply)
                                <div class="{{ $reply->is_admin_reply ? 'bg-brand/5 rounded-lg p-3' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-7 h-7 rounded-full {{ $reply->is_admin_reply ? 'bg-brand text-white' : 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }} flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                            {{ $reply->is_admin_reply ? '🏥' : strtoupper(substr($reply->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm flex items-center gap-1.5">
                                                {{ $reply->name }}
                                                @if ($reply->is_admin_reply)
                                                    <span
                                                        class="text-[10px] bg-brand text-white px-1.5 py-0.5 rounded-full">Hospital</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 ml-10">{{ $reply->body }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-sm">এই পোস্টে এখনো কোনো মন্তব্য নেই। প্রথম মন্তব্যটি আপনিই করুন!</p>
            @endforelse
        </div>

        {{-- New Top-Level Comment Form --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6">
            <h3 class="font-semibold mb-4">একটি মন্তব্য লিখুন</h3>
            @include('front.news._comment-form', ['parentId' => null])
        </div>
    </section>
@endsection
