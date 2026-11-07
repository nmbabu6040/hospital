<?php

namespace Database\Seeders;

use App\Models\OnlineReport;
use Illuminate\Database\Seeder;

class OnlineReportSeeder extends Seeder
{
    public function run(): void
    {
        OnlineReport::updateOrCreate(
            ['report_id' => 'RPT-DEMO0001'],
            [
                'patient_name' => 'Md. Karim Ahmed',
                'patient_id' => 'PT-00123',
                'phone' => '01712345678',
                'report_date' => now()->subDays(2),
                'status' => 'pending',
            ]
        );
    }
}
