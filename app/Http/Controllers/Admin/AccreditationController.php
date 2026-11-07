<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccreditationController extends Controller
{
    public function index()
    {
        $accreditations = Accreditation::orderBy('sort_order')->paginate(20);

        return view('admin.accreditations.index', compact('accreditations'));
    }

    public function create()
    {
        $accreditation = new Accreditation();

        return view('admin.accreditations.form', compact('accreditation'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('accreditations', 'public');
        }

        Accreditation::create($data);

        return redirect()->route('admin.accreditations.index')->with('success', 'Accreditation added successfully.');
    }

    public function edit(Accreditation $accreditation)
    {
        return view('admin.accreditations.form', compact('accreditation'));
    }

    public function update(Request $request, Accreditation $accreditation)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            if ($accreditation->logo) {
                Storage::disk('public')->delete($accreditation->logo);
            }
            $data['logo'] = $request->file('logo')->store('accreditations', 'public');
        }

        $accreditation->update($data);

        return redirect()->route('admin.accreditations.index')->with('success', 'Accreditation updated successfully.');
    }

    public function destroy(Accreditation $accreditation)
    {
        if ($accreditation->logo) {
            Storage::disk('public')->delete($accreditation->logo);
        }
        $accreditation->delete();

        return back()->with('success', 'Accreditation deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:1024'],
            'sort_order' => ['nullable', 'integer'],
        ]) + ['sort_order' => $request->input('sort_order', 0)];
    }
}
