<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(20);

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $video = new Video();

        return view('admin.videos.form', compact('video'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($data['is_featured']) {
            Video::where('is_featured', true)->update(['is_featured' => false]);
        }

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $data = $this->validateData($request);

        if ($data['is_featured']) {
            Video::where('is_featured', true)->where('id', '!=', $video->id)->update(['is_featured' => false]);
        }

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return back()->with('success', 'Video deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => ['required', 'string', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }
}
