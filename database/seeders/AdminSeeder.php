<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'branch_id' => null,
                'is_active' => true,
            ]
        );

        $dhanmondi = Branch::where('slug', 'dhanmondi-branch')->first();

        if ($dhanmondi) {
            Admin::updateOrCreate(
                ['email' => 'branch.dhanmondi@example.com'],
                [
                    'name' => 'Dhanmondi Branch Admin',
                    'password' => Hash::make('password123'),
                    'role' => 'branch_admin',
                    'branch_id' => $dhanmondi->id,
                    'is_active' => true,
                ]
            );
        }

        Admin::updateOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'branch_id' => null,
                'is_active' => true,
            ]
        );
    }
}
