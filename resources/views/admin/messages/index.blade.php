@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
    <h2 class="text-lg font-semibold mb-5">All Messages</h2>

    <div class="space-y-4">
        @forelse($messages as $message)
            <div class="bg-white rounded-lg shadow-sm p-5 {{ !$message->is_read ? 'border-l-4 border-brand' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold">{{ $message->name }}
                            {{ !$message->is_read ? '<span class="text-xs text-brand ml-2">● New</span>' : '' }}</h3>
                        <p class="text-xs text-gray-400">{{ $message->email }}
                            {{ $message->phone ? '| ' . $message->phone : '' }}</p>
                        @if ($message->subject)
                            <p class="text-sm font-medium mt-2">{{ $message->subject }}</p>
                        @endif
                        <p class="text-sm text-gray-600 mt-1">{{ $message->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $message->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                    <div class="flex gap-2 text-xs">
                        @if (!$message->is_read)
                            <form action="{{ route('admin.messages.read', $message) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-blue-600 hover:underline">Mark Read</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                            onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No messages yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $messages->links() }}</div>
@endsection
