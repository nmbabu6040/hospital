@extends('admin.layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All News</h2>
        <a href="{{ route('admin.news.create') }}" class="btn-primary">+ Add News</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Published</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newsItems as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ Str::limit($item->title, 60) }}</td>
                        <td class="p-3">{{ $item->published_at?->format('d M, Y') }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.news.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this news?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-5 text-center text-gray-500">No news found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $newsItems->links() }}</div>
@endsection
