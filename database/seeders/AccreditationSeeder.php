<?php

namespace Database\Seeders;

use App\Models\Accreditation;
use Illuminate\Database\Seeder;

class AccreditationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'NABH', 'description' => 'National Accreditation Board for Hospitals & Healthcare Providers', 'sort_order' => 1],
            ['name' => 'CAP', 'description' => 'College of American Pathologists Accreditation', 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            Accreditation::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
