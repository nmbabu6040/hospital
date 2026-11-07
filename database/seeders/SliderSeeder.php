<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        Slider::updateOrCreate(
            ['title' => 'Your Health, Our Priority'],
            [
                'subtitle' => 'বিশ্বমানের চিকিৎসা সেবা, আপনার কাছাকাছি।',
                'description' => 'অভিজ্ঞ ডাক্তার ও আধুনিক প্রযুক্তি নিয়ে আমরা সবসময় আপনার পাশে।',
                'cta_text' => 'Book Appointment',
                'cta_url' => '/book-appointment',
                'cta_text_2' => 'Find a Doctor',
                'cta_url_2' => '/doctors',
                'sort_order' => 1,
            ]
        );
    }
}
