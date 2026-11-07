<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'address', 'phone', 'is_active', 'latitude', 'longitude'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
