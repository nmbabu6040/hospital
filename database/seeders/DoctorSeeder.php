<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        $hospitals = Hospital::all();

        $firstNames = ['A.K.M. Rahman', 'Shahana Begum', 'Mizanur Rahman', 'Farida Yasmin', 'Kamal Hossain', 'Nasrin Sultana', 'Shahidul Islam', 'Rowshan Ara', 'Mahbubur Rahman', 'Shamima Akter', 'Abdur Razzaq', 'Nurjahan Begum', 'Rafiqul Islam', 'Tahmina Haque', 'Golam Mostofa', 'Selina Parvin', 'Anisur Rahman', 'Rehana Parvin', 'Jahangir Alam', 'Dilara Begum'];

        $degrees = ['MBBS, FCPS (Medicine)', 'MBBS, MD (Cardiology)', 'MBBS, MS (Surgery)', 'MBBS, FCPS (Gynae & Obs)', 'MBBS, DCH, MD (Pediatrics)', 'MBBS, FCPS (Neurology)'];
        $designations = ['Senior Consultant', 'Associate Consultant', 'Consultant', 'Professor', 'Assistant Professor', 'Specialist'];

        foreach ($firstNames as $i => $name) {
            $fullName = 'Dr. ' . $name;
            Doctor::updateOrCreate(
                ['slug' => Str::slug($fullName) . '-' . ($i + 1)],
                [
                    'name' => $fullName,
                    'designation' => $designations[$i % count($designations)],
                    'degree' => $degrees[$i % count($degrees)],
                    'department_id' => $departments[$i % $departments->count()]->id,
                    'hospital_id' => $hospitals[$i % $hospitals->count()]->id,
                    'chamber_time' => 'Sat - Thu: 5:00 PM - 9:00 PM',
                    'bio' => "{$fullName} is a highly experienced physician with years of dedicated service in patient care and clinical excellence.",
                    'is_active' => true,
                ]
            );
        }
    }
}