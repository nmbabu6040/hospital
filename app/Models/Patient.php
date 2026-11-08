<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'date_of_birth',
        'gender',
        'address',
        'blood_group',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function onlineReports()
    {
        return $this->hasMany(OnlineReport::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function videoConsultations()
    {
        return $this->hasMany(VideoConsultation::class);
    }
}
