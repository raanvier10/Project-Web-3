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
            ['email' => 'owner.efa@englishforakhwat.web.id'],
            [
                'name' => 'Owner EFA',
                'password' => Hash::make('OwnerEfa#12'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );
    }
}
