<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_id',
        'referred_by',
        'age',
        'gender',
        'phone',
        'report_id',
        'report_date',
        'status',
        'report_file',
        'comment',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
        ];
    }

    public function items()
    {
        return $this->hasMany(OnlineReportItem::class)->orderBy('sort_order');
    }

    public function hasGeneratedReport(): bool
    {
        return $this->items()->count() > 0;
    }
}
