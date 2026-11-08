<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name', 'blood_group', 'bags_needed', 'hospital_name',
        'district', 'contact_phone', 'needed_by_date', 'additional_info', 'is_fulfilled',
    ];

    protected function casts(): array
    {
        return [
            'needed_by_date' => 'date',
            'is_fulfilled' => 'boolean',
        ];
    }
}