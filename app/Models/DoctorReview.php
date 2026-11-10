<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorReview extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'name', 'email', 'rating', 'review', 'status', 'ip_address'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}