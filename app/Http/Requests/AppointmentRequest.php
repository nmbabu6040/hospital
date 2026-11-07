<?php

namespace App\Http\Requests;

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
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
