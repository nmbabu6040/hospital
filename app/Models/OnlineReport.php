<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name', 'patient_id', 'phone', 'report_id',
        'report_date', 'status', 'report_file',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
        ];
    }
}