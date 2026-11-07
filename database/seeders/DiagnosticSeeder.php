<?php

namespace Database\Seeders;

use App\Models\Diagnostic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiagnosticSeeder extends Seeder
{
    public function run(): void
    {
        $diagnostics = [
            [
                'name' => 'Labaid Diagnostic Dhanmondi',
                'address' => 'House 1, Road 4, Dhanmondi, Dhaka',
                'phone' => '09666-787804',
                'email' => 'diagnostic.dhanmondi@labaidhospital.com',
                'description' => 'A fully equipped diagnostic center offering pathology, imaging and cardiac investigation services under one roof.',
                'tests_available' => "CBC\nX-Ray\nUltrasound\nECG\nCT Scan\nMRI",
                'latitude' => 23.7461,
                'longitude' => 90.3742,
                'is_active' => true,
            ],
            [
                'name' => 'Labaid Diagnostic Mirpur',
                'address' => 'Mirpur-10, Dhaka',
                'phone' => '09666-787805',
                'email' => 'diagnostic.mirpur@labaidhospital.com',
                'description' => 'Modern diagnostic facility providing fast and accurate lab reports with home sample collection service.',
                'tests_available' => "Blood Sugar\nLipid Profile\nLiver Function Test\nKidney Function Test\nUrine R/E",
                'latitude' => 23.8041,
                'longitude' => 90.3650,
                'is_active' => true,
            ],
            [
                'name' => 'Labaid Diagnostic Uttara',
                'address' => 'Sector 7, Uttara, Dhaka',
                'phone' => '09666-787806',
                'email' => 'diagnostic.uttara@labaidhospital.com',
                'description' => 'Dedicated diagnostic branch serving the Uttara community with advanced imaging and pathology support.',
                'tests_available' => "Thyroid Profile\nEcho Cardiogram\nMammogram\nBone Density Test",
                'latitude' => 23.8759,
                'longitude' => 90.3990,
                'is_active' => true,
            ],
        ];

        foreach ($diagnostics as $d) {
            $d['slug'] = Str::slug($d['name']);
            Diagnostic::updateOrCreate(['slug' => $d['slug']], $d);
        }
    }
}
