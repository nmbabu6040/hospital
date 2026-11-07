<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic Health Checkup Package',
                'price' => 1500,
                'tests' => "CBC\nBlood Sugar (Fasting)\nLipid Profile\nUrine R/E\nChest X-Ray",
                'description' => 'A basic package designed for routine health screening.',
            ],
            [
                'name' => 'Executive Health Checkup Package',
                'price' => 5500,
                'tests' => "CBC\nLiver Function Test\nKidney Function Test\nLipid Profile\nECG\nUSG of Whole Abdomen\nChest X-Ray",
                'description' => 'Comprehensive package for busy executives to monitor overall health.',
            ],
            [
                'name' => 'Cardiac Risk Screening Package',
                'price' => 4500,
                'tests' => "ECG\nEcho Cardiogram\nLipid Profile\nTroponin I\nChest X-Ray",
                'description' => 'Focused package to assess cardiac risk factors early.',
            ],
            [
                'name' => "Women's Health Package",
                'price' => 3500,
                'tests' => "CBC\nPap Smear\nUSG of Lower Abdomen\nMammogram\nThyroid Profile",
                'description' => 'Specialized screening package designed for women\'s health needs.',
            ],
            [
                'name' => 'Senior Citizen Health Package',
                'price' => 6000,
                'tests' => "CBC\nBlood Sugar\nLipid Profile\nKidney Function Test\nLiver Function Test\nECG\nBone Density Test",
                'description' => 'Complete health monitoring package tailored for senior citizens.',
            ],
        ];

        foreach ($packages as $p) {
            $p['slug'] = Str::slug($p['name']);
            Package::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}