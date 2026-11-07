<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineReportItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'online_report_id', 'test_name', 'result_value',
        'unit', 'normal_range', 'is_abnormal', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_abnormal' => 'boolean',
        ];
    }

    public function report()
    {
        return $this->belongsTo(OnlineReport::class, 'online_report_id');
    }
}