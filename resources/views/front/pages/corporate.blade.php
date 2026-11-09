@extends('layouts.app')

@section('title', 'Corporate & Insurance Tie-ups')

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Corporate & Insurance Tie-ups</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-10">আমাদের সাথে চুক্তিবদ্ধ প্রতিষ্ঠানসমূহ</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div class="card p-5 text-center">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/160x100?text=' . urlencode($item->title) }}"
                        class="h-16 mx-auto mb-3 object-contain" loading="lazy" alt="{{ $item->title }}">
                    <p class="text-sm font-medium">{{ $item->title }}</p>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">কোনো তথ্য যোগ করা হয়নি।</p>
            @endforelse
        </div>
    </section>
@endsection
