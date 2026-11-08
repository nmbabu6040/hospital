<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BedCategory;
use App\Models\Hospital;
use Illuminate\Http\Request;

class BedCategoryController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with('bedCategories')->where('is_active', true)->get();

        return view('admin.bed-categories.index', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        BedCategory::create($data);

        return back()->with('success', 'Bed category added successfully.');
    }

    public function update(Request $request, BedCategory $bedCategory)
    {
        $data = $request->validate([
            'total_beds' => ['required', 'integer', 'min:0'],
            'available_beds' => ['required', 'integer', 'min:0', 'lte:total_beds'],
        ]);

        $bedCategory->update($data);

        return back()->with('success', 'Bed availability updated.');
    }

    public function destroy(BedCategory $bedCategory)
    {
        $bedCategory->delete();

        return back()->with('success', 'Bed category removed.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'ward_name' => ['required', 'string', 'max:255'],
            'total_beds' => ['required', 'integer', 'min:0'],
            'available_beds' => ['required', 'integer', 'min:0', 'lte:total_beds'],
        ]);
    }
}
