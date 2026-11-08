<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:patients,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:patients,phone'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
