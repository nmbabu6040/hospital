<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\QueueDisplay;
use Illuminate\Http\Request;

class QueueDisplayController extends Controller
{
    public function index()
    {
        $doctors = Doctor::where('is_active', true)->with('queueDisplay')->orderBy('name')->get();

        return view('admin.queue-displays.index', compact('doctors'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'current_serial' => ['nullable', 'string', 'max:20'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['queue_date'] = now()->format('Y-m-d');

        QueueDisplay::updateOrCreate(['doctor_id' => $doctor->id], $data);

        return back()->with('success', 'Queue updated for ' . $doctor->name);
    }
}
