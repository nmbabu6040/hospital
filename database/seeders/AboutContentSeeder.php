<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        AboutContent::updateOrCreate(
            ['id' => 1],
            [
                'md_name' => 'Managing Director',
                'md_designation' => 'MD & Founder',
                'md_message' => "আমাদের হাসপাতালে স্বাগতম। দীর্ঘদিন ধরে আমরা মানুষের সেবায় নিয়োজিত আছি সর্বোচ্চ মানসম্পন্ন চিকিৎসা প্রদানের মাধ্যমে।\n\nআমাদের লক্ষ্য হলো আধুনিক প্রযুক্তি এবং মানবিক পরিচর্যার সমন্বয়ে প্রতিটি রোগীকে সর্বোত্তম সেবা প্রদান করা।",
                'about_text' => "প্রতিষ্ঠার পর থেকে আমরা দেশের অন্যতম শীর্ষস্থানীয় স্বাস্থ্যসেবা প্রতিষ্ঠান হিসেবে পরিচিতি লাভ করেছি। আধুনিক চিকিৎসা প্রযুক্তি, অভিজ্ঞ চিকিৎসক এবং দক্ষ নার্সিং টিম নিয়ে আমরা রোগীদের সর্বোচ্চ মানের সেবা প্রদান করে আসছি।",
                'patients_count' => 50000,
                'staff_count' => 1200,
                'doctors_count' => 300,
            ]
        );
    }
}
