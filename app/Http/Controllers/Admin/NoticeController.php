<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest('publish_date')->paginate(20);

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        $notice = new Notice();

        return view('admin.notices.form', compact('notice'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = $request->file('attachment_file')->store('notices', 'public');
        }

        Notice::create($data);

        return redirect()->route('admin.notices.index')->with('success', 'Notice published successfully.');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.form', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('attachment_file')) {
            if ($notice->attachment_file) {
                Storage::disk('public')->delete($notice->attachment_file);
            }
            $data['attachment_file'] = $request->file('attachment_file')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        if ($notice->attachment_file) {
            Storage::disk('public')->delete($notice->attachment_file);
        }
        $notice->delete();

        return back()->with('success', 'Notice deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Tender,Notice,Circular,Announcement'],
            'description' => ['nullable', 'string'],
            'attachment_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'publish_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
