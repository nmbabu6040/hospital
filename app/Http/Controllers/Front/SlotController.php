<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\SlotService;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function availableDates(Doctor $doctor)
    {
        $dates = SlotService::availableDatesFor($doctor);

        return response()->json(['dates' => $dates]);
    }

    public function slots(Request $request, Doctor $doctor)
    {
        $request->validate(['date' => ['required', 'date']]);

        $slots = SlotService::generateSlotsFor($doctor, $request->date);

        return response()->json(['slots' => $slots]);
    }
}
