<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'email',
        'image',
        'description',
        'facilities',
        'map_embed',
        'is_active',
        'meta_title',
        'meta_description',
        'latitude',
        'longitude',
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

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function bedCategories()
    {
        return $this->hasMany(BedCategory::class);
    }

    public function totalBeds(): int
    {
        return $this->bedCategories()->sum('total_beds');
    }

    public function totalAvailableBeds(): int
    {
        return $this->bedCategories()->sum('available_beds');
    }
}
