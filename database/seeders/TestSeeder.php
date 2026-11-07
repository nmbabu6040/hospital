<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            ['name' => 'CBC (Complete Blood Count)', 'price' => 400, 'sample_type' => 'Blood', 'report_time' => '6 hours'],
            ['name' => 'Blood Sugar (Fasting)', 'price' => 100, 'sample_type' => 'Blood', 'report_time' => '2 hours', 'preparation' => '৮ ঘণ্টা খালি পেটে থাকতে হবে।'],
            ['name' => 'Lipid Profile', 'price' => 900, 'sample_type' => 'Blood', 'report_time' => '24 hours', 'preparation' => '১২ ঘণ্টা খালি পেটে থাকতে হবে।'],
            ['name' => 'Urine R/E', 'price' => 200, 'sample_type' => 'Urine', 'report_time' => '4 hours'],
            ['name' => 'Chest X-Ray', 'price' => 500, 'sample_type' => 'N/A', 'report_time' => '1 hour'],
            ['name' => 'Liver Function Test', 'price' => 1200, 'sample_type' => 'Blood', 'report_time' => '24 hours'],
            ['name' => 'Kidney Function Test', 'price' => 1100, 'sample_type' => 'Blood', 'report_time' => '24 hours'],
            ['name' => 'ECG', 'price' => 400, 'sample_type' => 'N/A', 'report_time' => 'Same day'],
            ['name' => 'USG of Whole Abdomen', 'price' => 1500, 'sample_type' => 'N/A', 'report_time' => 'Same day'],
            ['name' => 'Thyroid Profile', 'price' => 1300, 'sample_type' => 'Blood', 'report_time' => '24 hours'],
        ];

        foreach ($tests as $t) {
            $t['slug'] = Str::slug($t['name']) . '-' . uniqid();
            $t['is_active'] = true;
            Test::updateOrCreate(['name' => $t['name']], $t);
        }

        // ডেমো হিসেবে Basic Health Checkup Package-এর সাথে কিছু Test attach করে দিচ্ছি
        $basicPackage = Package::where('slug', 'like', 'basic-health-checkup-package%')->first();

        if ($basicPackage) {
            $testIds = Test::whereIn('name', ['CBC (Complete Blood Count)', 'Blood Sugar (Fasting)', 'Urine R/E', 'Chest X-Ray'])->pluck('id');
            $basicPackage->individualTests()->syncWithoutDetaching($testIds);
        }
    }
}
