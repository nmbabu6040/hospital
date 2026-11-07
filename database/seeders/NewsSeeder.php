<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $newsItems = [
            [
                'title' => 'Labaid Hospital Launches New Cardiac Care Unit',
                'content' => 'Labaid Hospital has inaugurated a new state-of-the-art cardiac care unit equipped with the latest technology to serve patients with heart conditions more effectively.',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Free Health Checkup Camp Organized in Dhanmondi',
                'content' => 'A free health checkup camp was organized by Labaid Hospital in Dhanmondi, where hundreds of people received free consultations and basic diagnostic tests.',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Labaid Receives NABH Accreditation',
                'content' => 'Labaid Specialized Hospital has been awarded the prestigious NABH accreditation, recognizing its commitment to quality patient care and safety standards.',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'New MRI Machine Installed at Diagnostic Center',
                'content' => 'A new high-resolution MRI machine has been installed at the Labaid Diagnostic Center to provide faster and more accurate imaging services to patients.',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Labaid Celebrates World Health Day with Awareness Program',
                'content' => 'Labaid Hospital organized an awareness program on World Health Day, focusing on preventive healthcare and community wellness initiatives.',
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($newsItems as $n) {
            $n['slug'] = Str::slug($n['title']);
            News::updateOrCreate(['slug' => $n['slug']], $n);
        }
    }
}