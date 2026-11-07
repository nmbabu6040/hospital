<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort_order')->latest()->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $page = new Page();

        return view('admin.pages.form', compact('page'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['title']);

        // slug ইউনিক নিশ্চিত করা (ম্যানুয়াল চেক, কারণ edit এ unique rule আলাদা হবে)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validateData($request, $page->id);

        if (! empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = $page->slug;
        }

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }
        $page->delete();

        return back()->with('success', 'Page deleted successfully.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('pages', 'slug')->ignore($ignoreId),
            ],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'show_in_menu' => ['nullable', 'boolean'],
            'menu_location' => ['required', 'in:header,footer,none'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'show_in_menu' => $request->boolean('show_in_menu'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ];
    }
}
