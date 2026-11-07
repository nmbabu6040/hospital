<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Dhanmondi Branch', 'address' => 'Dhanmondi, Dhaka', 'phone' => '09666-787801'],
            ['name' => 'Mirpur Branch', 'address' => 'Mirpur, Dhaka', 'phone' => '09666-787803'],
            ['name' => 'Uttara Branch', 'address' => 'Uttara, Dhaka', 'phone' => '09666-787806'],
        ];

        foreach ($branches as $b) {
            $b['slug'] = Str::slug($b['name']);
            $b['is_active'] = true;
            Branch::updateOrCreate(['slug' => $b['slug']], $b);
        }
    }
}
