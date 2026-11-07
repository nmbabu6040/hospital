<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::where('is_active', true)->with(['department', 'hospital']);

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('hospital')) {
            $query->where('hospital_id', $request->hospital);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $doctors = $query->orderBy('name')->paginate(20)->withQueryString();

        $departments = Department::orderBy('name')->get();
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();

        return view('front.doctors.index', compact('doctors', 'departments', 'hospitals'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['department', 'hospital']);

        return view('front.doctors.show', compact('doctor'));
    }
}
