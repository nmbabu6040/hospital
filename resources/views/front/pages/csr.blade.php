@extends('layouts.app')

@section('title', 'Corporate Social Responsibility')

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Corporate Social Responsibility</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-10">সমাজের প্রতি আমাদের দায়বদ্ধতা</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="card overflow-hidden">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-44 object-cover" loading="lazy"
                            alt="{{ $item->title }}">
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold mb-2">{{ $item->title }}</h3>
                        @if ($item->item_date)
                            <p class="text-xs text-gray-400 mb-2">{{ $item->item_date->format('d M, Y') }}</p>
                        @endif
                        @if ($item->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                {{ Str::limit($item->description, 120) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">কোনো তথ্য যোগ করা হয়নি।</p>
            @endforelse
        </div>
    </section>
@endsection
