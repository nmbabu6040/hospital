@extends('layouts.app')

@section('title', 'Awards & Recognition')

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Awards & Recognition</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-10">আমাদের অর্জন ও স্বীকৃতি</p>

        <div class="space-y-6">
            @forelse($items as $item)
                <div class="card p-6 flex flex-col md:flex-row gap-5 items-start">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full md:w-48 h-32 object-cover rounded-md"
                            loading="lazy" alt="{{ $item->title }}">
                    @endif
                    <div>
                        <h2 class="font-semibold text-lg">{{ $item->title }}</h2>
                        @if ($item->item_date)
                            <p class="text-xs text-gray-400 mt-1">{{ $item->item_date->format('Y') }}</p>
                        @endif
                        @if ($item->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 leading-relaxed">
                                {{ $item->description }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-10">কোনো তথ্য যোগ করা হয়নি।</p>
            @endforelse
        </div>
    </section>
@endsection
