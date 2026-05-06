<?php

namespace Database\Seeders;

use App\Models\CoursePackage;
use Illuminate\Database\Seeder;

class CoursePackageSeeder extends Seeder
{
    /**
     * Seed sample course packages.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'English Kids Starter',
                'category' => 'kids',
                'descriptions' => 'Program dasar bahasa Inggris untuk anak dengan metode belajar yang menyenangkan.',
                'price' => 350000,
                'amount' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'English Kids Advanced',
                'category' => 'kids',
                'descriptions' => 'Program lanjutan untuk anak yang sudah memahami dasar-dasar bahasa Inggris.',
                'price' => 500000,
                'amount' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'English Adult Basic',
                'category' => 'adult',
                'descriptions' => 'Kelas dasar untuk dewasa yang ingin mulai belajar bahasa Inggris dari nol.',
                'price' => 450000,
                'amount' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'English Adult Intensive',
                'category' => 'adult',
                'descriptions' => 'Program intensif untuk meningkatkan speaking, listening, dan grammar.',
                'price' => 750000,
                'amount' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            CoursePackage::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
