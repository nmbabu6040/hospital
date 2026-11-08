<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    public function index()
    {
        $ambulances = Ambulance::with('branch')->latest()->paginate(20);

        return view('admin.ambulances.index', compact('ambulances'));
    }

    public function create()
    {
        $ambulance = new Ambulance();
        $branches = \App\Models\Branch::where('is_active', true)->get();

        return view('admin.ambulances.form', compact('ambulance', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Ambulance::create($data);

        return redirect()->route('admin.ambulances.index')->with('success', 'Ambulance added successfully.');
    }

    public function edit(Ambulance $ambulance)
    {
        $branches = \App\Models\Branch::where('is_active', true)->get();

        return view('admin.ambulances.form', compact('ambulance', 'branches'));
    }

    public function update(Request $request, Ambulance $ambulance)
    {
        $data = $this->validateData($request);
        $ambulance->update($data);

        return redirect()->route('admin.ambulances.index')->with('success', 'Ambulance updated successfully.');
    }

    public function destroy(Ambulance $ambulance)
    {
        $ambulance->delete();

        return back()->with('success', 'Ambulance removed.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'vehicle_no' => ['required', 'string', 'max:50'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'driver_phone' => ['nullable', 'string', 'max:20'],
            'type' => ['required', 'in:Basic,ICU,Freezer'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'status' => ['required', 'in:available,on_duty,maintenance'],
        ]);
    }
}
