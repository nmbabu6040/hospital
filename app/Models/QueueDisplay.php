<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueDisplay extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'current_serial', 'queue_date', 'is_active'];

    protected function casts(): array
    {
        return [
            'queue_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}