<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Cardiology', 'Neurology', 'Orthopedics', 'Gynecology & Obstetrics',
            'Pediatrics', 'Oncology', 'Nephrology', 'Gastroenterology',
            'Urology', 'ENT', 'Dermatology', 'Endocrinology',
            'General Surgery', 'Internal Medicine', 'Ophthalmology',
        ];

        $featured = ['Cardiology', 'Neurology', 'Orthopedics', 'Gynecology & Obstetrics', 'Pediatrics', 'Oncology', 'Nephrology', 'Gastroenterology'];

        foreach ($departments as $i => $name) {
            Department::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => "The Department of {$name} provides comprehensive diagnostic and treatment services with a team of expert consultants and modern equipment.",
                    'services' => "Consultation, Diagnosis, Treatment, Follow-up care for {$name} related conditions.",
                    'is_featured' => in_array($name, $featured),
                    'sort_order' => $i,
                ]
            );
        }
    }
}