@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
    <h2 class="text-lg font-semibold mb-5">All Notifications</h2>

    <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-100">
        @forelse($notifications as $notification)
            <a href="{{ route('admin.notifications.read', $notification) }}"
                class="flex items-start gap-3 px-5 py-4 hover:bg-gray-50 transition {{ !$notification->is_read ? 'bg-blue-50/40' : '' }}">
                <span class="text-xl flex-shrink-0">{{ $notification->icon() }}</span>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-sm text-gray-800">{{ $notification->title }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $notification->body }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if (!$notification->is_read)
                    <span class="w-2 h-2 bg-brand rounded-full flex-shrink-0 mt-2"></span>
                @endif
            </a>
        @empty
            <p class="text-center text-gray-500 py-10">কোনো নোটিফিকেশন নেই।</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
@endsection
