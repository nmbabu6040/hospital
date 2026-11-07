<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'logo' => null,
                'hotline' => '09666-787801',
                'address' => 'House 06, Road 04, Dhanmondi, Dhaka-1205, Bangladesh',
                'email' => 'info@labaidhospital.com',
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'youtube_url' => 'https://youtube.com',
                'diagnostic_url' => 'https://example-diagnostic.com',
                'footer_text' => '© ' . date('Y') . ' Labaid Clone Hospital. All rights reserved.',
            ]
        );
    }
}