@extends('admin.layouts.app')

@section('title', 'Videos')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Videos</h2>
        <a href="{{ route('admin.videos.create') }}" class="btn-primary">+ Add Video</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">URL</th>
                    <th class="p-3">Featured</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videos as $video)
                    <tr class="border-t">
                        <td class="p-3">{{ $video->title }}</td>
                        <td class="p-3">{{ Str::limit($video->youtube_url, 40) }}</td>
                        <td class="p-3">
                            @if ($video->is_featured)
                                <span class="px-2 py-1 rounded-full text-xs bg-brand text-white">Homepage</span>
                            @endif
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.videos.edit', $video) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No videos found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $videos->links() }}</div>
@endsection
