@extends('layouts.app')

@section('title', 'Notice Board')

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Notice Board</h1>

        <div class="flex flex-wrap gap-2 justify-center mb-8">
            <a href="{{ route('notices.index') }}"
                class="px-3 py-1.5 rounded-full text-sm {{ !request('category') ? 'bg-brand text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            @foreach (['Tender', 'Notice', 'Circular', 'Announcement'] as $cat)
                <a href="{{ route('notices.index', ['category' => $cat]) }}"
                    class="px-3 py-1.5 rounded-full text-sm {{ request('category') == $cat ? 'bg-brand text-white' : 'bg-gray-100 text-gray-600' }}">{{ $cat }}</a>
            @endforeach
        </div>

        <div class="space-y-3">
            @forelse($notices as $notice)
                <a href="{{ route('notices.show', $notice) }}"
                    class="card p-4 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <span class="text-xs bg-brand/10 text-brand px-2 py-0.5 rounded-full">{{ $notice->category }}</span>
                        <p class="font-medium text-sm mt-1">{{ $notice->title }}</p>
                    </div>
                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $notice->publish_date->format('d M, Y') }}</span>
                </a>
            @empty
                <p class="text-center text-gray-500 py-16">কোনো নোটিশ পাওয়া যায়নি।</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $notices->links() }}</div>
    </section>
@endsection
