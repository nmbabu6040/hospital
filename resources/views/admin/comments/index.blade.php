@extends('admin.layouts.app')

@section('title', 'Comments')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Comments Moderation</h2>

        <div class="flex gap-2 text-sm">
            <a href="{{ route('admin.comments.index') }}"
                class="px-3 py-1.5 rounded-md {{ !request('status') ? 'bg-brand text-white' : 'bg-gray-100 text-gray-600' }}">
                All ({{ $counts['pending'] + $counts['approved'] + $counts['rejected'] }})
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                Pending ({{ $counts['pending'] }})
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                Approved ({{ $counts['approved'] }})
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'rejected']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                Rejected ({{ $counts['rejected'] }})
            </a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white rounded-lg shadow-sm p-5 {{ $comment->is_admin_reply ? 'border-l-4 border-brand' : '' }}">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-semibold text-sm">{{ $comment->name }}</p>
                            <span class="text-xs text-gray-400">{{ $comment->email }}</span>
                            @if ($comment->is_admin_reply)
                                <span class="text-xs bg-brand/10 text-brand px-2 py-0.5 rounded-full font-medium">🏥
                                    Hospital Reply</span>
                            @endif
                            @if ($comment->parent_id)
                                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">Reply to:
                                    {{ Str::limit($comment->parent?->body, 30) }}</span>
                            @endif
                            <span
                                class="px-2 py-0.5 rounded-full text-xs
                            {{ $comment->status == 'approved' ? 'bg-green-100 text-green-700' : ($comment->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ $comment->body }}</p>
                        <p class="text-xs text-gray-400 mt-2">
                            On: <a href="{{ route('news.show', $comment->news) }}" target="_blank"
                                class="text-blue-600 hover:underline">{{ $comment->news->title }}</a>
                            · {{ $comment->created_at->diffForHumans() }}
                            @if ($comment->ip_address)
                                · IP: {{ $comment->ip_address }}
                            @endif
                        </p>

                        {{-- Reply Form Toggle (শুধু approved, non-admin-reply কমেন্টেই দেখাবে) --}}
                        @if (!$comment->is_admin_reply)
                            <button type="button"
                                onclick="document.getElementById('admin-reply-{{ $comment->id }}').classList.toggle('hidden')"
                                class="text-xs text-brand hover:underline mt-3">💬 Reply as Hospital</button>

                            <div id="admin-reply-{{ $comment->id }}" class="hidden mt-3 pl-3 border-l-2 border-gray-100">
                                <form action="{{ route('admin.comments.reply', $comment) }}" method="POST"
                                    class="flex gap-2">
                                    @csrf
                                    <textarea name="body" rows="2" required placeholder="আপনার জবাব লিখুন..."
                                        class="flex-1 border border-gray-200 rounded-md px-3 py-2 text-sm"></textarea>
                                    <button type="submit" class="btn-primary text-sm self-start">Send</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-2 flex-shrink-0 text-xs">
                        @if ($comment->status !== 'approved')
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-green-600 hover:underline">Approve</button>
                            </form>
                        @endif
                        @if ($comment->status !== 'rejected')
                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-amber-600 hover:underline">Reject</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                            onsubmit="return confirm('Delete this comment permanently?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No comments found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $comments->links() }}</div>
@endsection
