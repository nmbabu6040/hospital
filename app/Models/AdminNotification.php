<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class AdminNotification extends Model
{
    use HasFactory, Prunable;

    protected $fillable = ['type', 'title', 'body', 'link', 'branch_id', 'is_read'];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(30));
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function icon(): string
    {
        return match ($this->type) {
            'appointment' => '📅',
            'message' => '💬',
            'comment' => '📝',
            default => '🔔',
        };
    }

    public function scopeForAdmin($query, Admin $admin)
    {
        if ($admin->isBranchAdmin() && $admin->branch_id) {
            return $query->where(function ($q) use ($admin) {
                $q->where('branch_id', $admin->branch_id)->orWhereNull('branch_id');
            });
        }

        return $query;
    }
}
