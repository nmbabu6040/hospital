<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ambulance_id', 'patient_id', 'requester_name', 'phone',
        'pickup_location', 'drop_location', 'ambulance_type',
        'is_emergency', 'additional_info', 'status',
    ];

    protected function casts(): array
    {
        return [
            'is_emergency' => 'boolean',
        ];
    }

    public function ambulance()
    {
        return $this->belongsTo(Ambulance::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}