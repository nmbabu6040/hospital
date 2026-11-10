<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
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

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'password' => 'hashed',
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class);
    }

    public function reviews()
    {
        return $this->hasMany(DoctorReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(DoctorReview::class)->approved()->latest();
    }

    public function averageRating(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function reviewCount(): int
    {
        return $this->approvedReviews()->count();
    }

    public function ratingBreakdown(): array
    {
        $breakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $counts = $this->approvedReviews()->selectRaw('rating, count(*) as total')->groupBy('rating')->pluck('total', 'rating');

        foreach ($counts as $rating => $count) {
            $breakdown[$rating] = $count;
        }

        return $breakdown;
    }

    public function queueDisplay()
    {
        return $this->hasOne(QueueDisplay::class);
    }
}
