@extends('admin.layouts.app')

@section('title', 'Doctor Reviews')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Doctor Reviews Moderation</h2>

        <div class="flex gap-2 text-sm">
            <a href="{{ route('admin.doctor-reviews.index') }}"
                class="px-3 py-1.5 rounded-md {{ !request('status') ? 'bg-brand text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            <a href="{{ route('admin.doctor-reviews.index', ['status' => 'pending']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-600' }}">Pending
                ({{ $counts['pending'] }})</a>
            <a href="{{ route('admin.doctor-reviews.index', ['status' => 'approved']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">Approved
                ({{ $counts['approved'] }})</a>
            <a href="{{ route('admin.doctor-reviews.index', ['status' => 'rejected']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600' }}">Rejected
                ({{ $counts['rejected'] }})</a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-semibold text-sm">{{ $review->name }}</p>
                            <span class="text-xs text-gray-400">{{ $review->email }}</span>
                            <span
                                class="text-amber-500 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            <span
                                class="px-2 py-0.5 rounded-full text-xs
                            {{ $review->status == 'approved' ? 'bg-green-100 text-green-700' : ($review->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>
                        @if ($review->review)
                            <p class="text-sm text-gray-600 mt-2">{{ $review->review }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-2">
                            For: <strong>{{ $review->doctor->name }}</strong> · {{ $review->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="flex gap-2 flex-shrink-0 text-xs">
                        @if ($review->status !== 'approved')
                            <form action="{{ route('admin.doctor-reviews.approve', $review) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-green-600 hover:underline">Approve</button>
                            </form>
                        @endif
                        @if ($review->status !== 'rejected')
                            <form action="{{ route('admin.doctor-reviews.reject', $review) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-amber-600 hover:underline">Reject</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.doctor-reviews.destroy', $review) }}" method="POST"
                            onsubmit="return confirm('Delete permanently?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No reviews found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>
@endsection
