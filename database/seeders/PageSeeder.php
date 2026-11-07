<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => "আপনার ব্যক্তিগত তথ্যের গোপনীয়তা আমাদের কাছে অত্যন্ত গুরুত্বপূর্ণ।\n\nআমরা শুধুমাত্র প্রয়োজনীয় তথ্য সংগ্রহ করি এবং তা সেবার মান উন্নত করতে ব্যবহার করি। আপনার তথ্য কোনো তৃতীয় পক্ষের সাথে শেয়ার করা হয় না, আইনি বাধ্যবাধকতা ছাড়া।",
                'show_in_menu' => true,
                'menu_location' => 'footer',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'content' => "আমাদের ওয়েবসাইট ব্যবহার করে আপনি নিম্নলিখিত শর্তাবলীতে সম্মত হচ্ছেন।\n\nঅ্যাপয়েন্টমেন্ট বুকিং, রিপোর্ট ডাউনলোড এবং অন্যান্য সেবা ব্যবহারের ক্ষেত্রে সঠিক তথ্য প্রদান আপনার দায়িত্ব।",
                'show_in_menu' => true,
                'menu_location' => 'footer',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
