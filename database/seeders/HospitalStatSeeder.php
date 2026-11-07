<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\HospitalStat;
use Illuminate\Database\Seeder;

class HospitalStatSeeder extends Seeder
{
    public function run(): void
    {
        $hospital = Hospital::first();

        for ($i = 0; $i < 60; $i++) {
            $date = now()->subDays($i);

            HospitalStat::updateOrCreate(
                ['stat_date' => $date->format('Y-m-d'), 'hospital_id' => $hospital?->id, 'branch_id' => null],
                [
                    'patients_admitted' => rand(15, 45),
                    'patients_discharged' => rand(10, 40),
                    'test_only_patients' => rand(30, 90),
                    'opd_patients' => rand(50, 150),
                    'emergency_patients' => rand(5, 25),
                ]
            );
        }
    }
}
