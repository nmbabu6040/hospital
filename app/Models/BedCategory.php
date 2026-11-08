<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedCategory extends Model
{
    use HasFactory;

    protected $fillable = ['hospital_id', 'ward_name', 'total_beds', 'available_beds'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function occupancyPercent(): float
    {
        if ($this->total_beds === 0) {
            return 0;
        }

        return round((($this->total_beds - $this->available_beds) / $this->total_beds) * 100, 1);
    }

    public function statusColor(): string
    {
        $percent = $this->occupancyPercent();

        if ($percent >= 90) {
            return 'red';
        } elseif ($percent >= 70) {
            return 'amber';
        }

        return 'green';
    }
}