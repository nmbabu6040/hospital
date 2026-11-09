<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'department', 'job_type', 'location', 'vacancies',
        'description', 'requirements', 'responsibilities', 'salary_range',
        'deadline', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function isExpired(): bool
    {
        return $this->deadline->isPast();
    }

    public function isOpen(): bool
    {
        return $this->is_active && ! $this->isExpired();
    }
}