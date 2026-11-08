<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'patient_id', 'patient_name', 'phone', 'email', 'reason',
        'preferred_date', 'preferred_time', 'status', 'scheduled_at',
        'meeting_room_id', 'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'scheduled_at' => 'datetime',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function meetingUrl(): ?string
    {
        return $this->meeting_room_id ? 'https://meet.jit.si/' . $this->meeting_room_id : null;
    }

    public function isJoinable(): bool
    {
        if ($this->status !== 'scheduled' || ! $this->scheduled_at) {
            return false;
        }

        // শিডিউল সময়ের ১৫ মিনিট আগে থেকে ৬০ মিনিট পর পর্যন্ত জয়েন করা যাবে
        return now()->between(
            $this->scheduled_at->copy()->subMinutes(15),
            $this->scheduled_at->copy()->addMinutes(60)
        );
    }
}