<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorLeave extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'leave_date', 'reason'];

    protected function casts(): array
    {
        return [
            'leave_date' => 'date',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
