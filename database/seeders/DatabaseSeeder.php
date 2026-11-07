<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            AdminSeeder::class,
            HospitalSeeder::class,
            DepartmentSeeder::class,
            DoctorSeeder::class,
            PackageSeeder::class,
            NewsSeeder::class,
            DiagnosticSeeder::class,
            SettingSeeder::class,
            OnlineReportSeeder::class,
            AboutContentSeeder::class,
            AccreditationSeeder::class,
            PageSeeder::class,
            TestSeeder::class,
            SliderSeeder::class,
            HospitalStatSeeder::class,
        ]);
    }
}
