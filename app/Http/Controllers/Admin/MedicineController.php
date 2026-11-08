<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('filter') && $request->filter === 'low_stock') {
            $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
        }

        $medicines = $query->latest()->paginate(25)->withQueryString();

        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $medicine = new Medicine();

        return view('admin.medicines.form', compact('medicine'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.form', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $this->validateData($request);
        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return back()->with('success', 'Medicine deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'requires_prescription' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'requires_prescription' => $request->boolean('requires_prescription'),
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
