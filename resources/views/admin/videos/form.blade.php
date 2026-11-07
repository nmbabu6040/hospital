@extends('admin.layouts.app')

@section('title', $video->exists ? 'Edit Video' : 'Add Video')

@section('content')
    <form action="{{ $video->exists ? route('admin.videos.update', $video) : route('admin.videos.store') }}" method="POST"
        class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($video->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $video->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">YouTube Video URL <span class="text-red-500">*</span></label>
            <input type="text" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" required
                placeholder="https://www.youtube.com/watch?v=VIDEO_ID"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">ব্রাউজারের ঠিকানা বার থেকে সরাসরি YouTube ভিডিওর লিংক কপি করে বসাও (watch
                URL, youtu.be, বা embed — যেকোনো ফরম্যাট চলবে)।</p>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_featured" value="1"
                {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}>
            হোমপেজের "Doctor's Talk" সেকশনে এই ভিডিওটা দেখাও
        </label>
        <p class="text-xs text-gray-400 -mt-3">একটা ভিডিও ফিচার করলে আগের ফিচার্ড ভিডিওটা স্বয়ংক্রিয়ভাবে সরে যাবে — একসাথে
            শুধু একটাই দেখাবে।</p>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
