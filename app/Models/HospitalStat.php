<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_date', 'hospital_id', 'branch_id',
        'patients_admitted', 'patients_discharged', 'test_only_patients',
        'opd_patients', 'emergency_patients', 'notes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'stat_date' => 'date',
        ];
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function totalPatients(): int
    {
        return $this->patients_admitted + $this->test_only_patients + $this->opd_patients + $this->emergency_patients;
    }

    public function scopeForAdmin($query, Admin $admin)
    {
        if ($admin->isBranchAdmin() && $admin->branch_id) {
            return $query->where('branch_id', $admin->branch_id);
        }

        return $query;
    }

    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('stat_date', [$start, $end]);
    }
}