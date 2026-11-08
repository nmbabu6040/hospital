<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_no', 'driver_name', 'driver_phone', 'type', 'branch_id', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function requests()
    {
        return $this->hasMany(AmbulanceRequest::class);
    }
}