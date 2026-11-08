<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonor extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'name', 'phone', 'email', 'blood_group', 'district', 'area',
        'last_donation_date', 'age', 'gender', 'is_available', 'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'last_donation_date' => 'date',
            'is_available' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * শেষ রক্তদানের তারিখ অনুযায়ী এখন donate করার যোগ্য কিনা (সাধারণত ৩ মাস/৯০ দিন গ্যাপ লাগে)
     */
    public function isEligibleNow(): bool
    {
        if (! $this->last_donation_date) {
            return true;
        }

        return $this->last_donation_date->diffInDays(now()) >= 90;
    }
}