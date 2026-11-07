<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('sort_order')->orderBy('name')->get();

        return view('front.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $doctors = $department->doctors()->where('is_active', true)->get();

        return view('front.departments.show', compact('department', 'doctors'));
    }
}
