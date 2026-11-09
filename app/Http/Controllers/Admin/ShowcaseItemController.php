<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShowcaseItemController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'corporate');
        $items = ShowcaseItem::where('type', $type)->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.showcase-items.index', compact('items', 'type'));
    }

    public function create(Request $request)
    {
        $item = new ShowcaseItem(['type' => $request->input('type', 'corporate')]);

        return view('admin.showcase-items.form', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('showcase', 'public');
        }

        ShowcaseItem::create($data);

        return redirect()->route('admin.showcase-items.index', ['type' => $data['type']])->with('success', 'Item added successfully.');
    }

    public function edit(ShowcaseItem $showcaseItem)
    {
        return view('admin.showcase-items.form', ['item' => $showcaseItem]);
    }

    public function update(Request $request, ShowcaseItem $showcaseItem)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($showcaseItem->image) {
                Storage::disk('public')->delete($showcaseItem->image);
            }
            $data['image'] = $request->file('image')->store('showcase', 'public');
        }

        $showcaseItem->update($data);

        return redirect()->route('admin.showcase-items.index', ['type' => $data['type']])->with('success', 'Item updated successfully.');
    }

    public function destroy(ShowcaseItem $showcaseItem)
    {
        $type = $showcaseItem->type;

        if ($showcaseItem->image) {
            Storage::disk('public')->delete($showcaseItem->image);
        }
        $showcaseItem->delete();

        return redirect()->route('admin.showcase-items.index', ['type' => $type])->with('success', 'Item deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:corporate,award,csr'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'item_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active'), 'sort_order' => $request->input('sort_order', 0)];
    }
}
