<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Seed the owner user for testing.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'forakhwatenglish@gmail.com'],
            [
                'name' => 'Owner EFA',
                'password' => Hash::make('EnglishForAkhwat1010!'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );
    }
}
