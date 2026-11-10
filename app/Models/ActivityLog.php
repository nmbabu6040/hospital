<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'action', 'subject_type', 'subject_id', 'subject_label', 'ip_address'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public static function record(string $action, string $subjectType, ?int $subjectId, ?string $subjectLabel): void
    {
        self::create([
            'admin_id' => auth('admin')->id(),
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'subject_label' => $subjectLabel,
            'ip_address' => request()->ip(),
        ]);
    }

    public function icon(): string
    {
        return match ($this->action) {
            'created' => '✅',
            'updated' => '✏️',
            'deleted' => '🗑️',
            default => '📝',
        };
    }
}