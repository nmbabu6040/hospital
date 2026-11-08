<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'slot_time' => ['nullable', 'date_format:H:i:s'],
            'slot_end_time' => ['nullable', 'date_format:H:i:s'],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // যদি doctor + date + slot_time দেওয়া থাকে, ডাবল-বুকিং চেক করো (server-side guard)
            if ($this->doctor_id && $this->date && $this->slot_time) {
                $doctor = \App\Models\Doctor::find($this->doctor_id);

                if ($doctor) {
                    $schedule = $doctor->schedules()
                        ->where('day_of_week', \Carbon\Carbon::parse($this->date)->dayOfWeek)
                        ->where('is_active', true)
                        ->first();

                    $maxPatients = $schedule?->max_patients_per_slot ?? 1;

                    $bookedCount = Appointment::where('doctor_id', $this->doctor_id)
                        ->whereDate('date', $this->date)
                        ->where('slot_time', $this->slot_time)
                        ->where('status', '!=', 'Cancelled')
                        ->count();

                    if ($bookedCount >= $maxPatients) {
                        $validator->errors()->add('slot_time', 'দুঃখিত, এই সময়ের স্লটটি এখন ফুল হয়ে গেছে। অন্য একটি সময় বেছে নিন।');
                    }
                }
            }
        });
    }
}
