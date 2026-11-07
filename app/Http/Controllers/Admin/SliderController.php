<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->paginate(20);

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $slider = new Slider();

        return view('admin.sliders.form', compact('slider'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['image'] = $request->file('image')->store('sliders', 'public');

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider added successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return back()->with('success', 'Slider deleted successfully.');
    }

    private function validateData(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:3072'],
            'sort_order' => ['nullable', 'integer'],
            'cta_text' => ['nullable', 'string', 'max:50'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'cta_text_2' => ['nullable', 'string', 'max:50'],
            'cta_url_2' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
