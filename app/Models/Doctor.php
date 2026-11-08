<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'designation',
        'degree',
        'image',
        'department_id',
        'hospital_id',
        'branch_id',
        'chamber_time',
        'bio',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
