<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            [
                'name' => 'Labaid Specialized Hospital',
                'address' => 'House 06, Road 04, Dhanmondi, Dhaka',
                'phone' => '09666-787801',
                'email' => 'info@labaidhospital.com',
                'description' => 'A leading multi-disciplinary tertiary care hospital offering advanced diagnostic and treatment facilities.',
                'facilities' => 'ICU, CCU, NICU, Operation Theatre, 24/7 Emergency, Modern Diagnostic Center',
                'latitude' => 23.7461,
                'longitude' => 90.3742,
                'is_active' => true,
            ],
            [
                'name' => 'Labaid Cardiac Hospital',
                'address' => 'House 1, Road 4, Dhanmondi, Dhaka',
                'phone' => '09666-787802',
                'email' => 'cardiac@labaidhospital.com',
                'description' => 'Dedicated cardiac care hospital with advanced cath lab and cardiac surgery facilities.',
                'facilities' => 'Cath Lab, Cardiac ICU, Open Heart Surgery, Pacemaker Implant Unit',
                'latitude' => 23.7465,
                'longitude' => 90.3750,
                'is_active' => true,
            ],
            [
                'name' => 'Labaid Diagnostic Mirpur',
                'address' => 'Mirpur-10, Dhaka',
                'phone' => '09666-787803',
                'email' => 'mirpur@labaidhospital.com',
                'description' => 'Full-service diagnostic center with modern imaging and pathology lab.',
                'facilities' => 'MRI, CT Scan, X-Ray, Pathology, Ultrasound',
                'latitude' => 23.8041,
                'longitude' => 90.3742,
                'is_active' => true,
            ],
        ];

        foreach ($hospitals as $h) {
            $h['slug'] = Str::slug($h['name']);
            Hospital::updateOrCreate(['slug' => $h['slug']], $h);
        }
    }
}
