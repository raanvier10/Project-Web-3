<?php

namespace Database\Seeders;

use App\Models\CoursePackage;
use Illuminate\Database\Seeder;

class CoursePackageSeeder extends Seeder
{
    /**
     * Seed course packages for Kids and Adult programs.
     */
    public function run(): void
    {
        $packages = [
            [
                'name'         => 'English for Kids - Basic',
                'category'     => 'kids',
                'descriptions' => 'Program dasar bahasa Inggris untuk anak-anak usia 4-15 tahun. Belajar dengan metode fun learning yang interaktif dan menyenangkan.',
                'features'     => 'Kelas interaktif 2x seminggu|Materi sesuai usia anak|Games & aktivitas seru|Sertifikat kelulusan|Grup WhatsApp orang tua|Free placement test',
                'price'        => 350000,
                'amount'       => 20,
                'is_active'    => true,
            ],
            [
                'name'         => 'English for Kids - Intermediate',
                'category'     => 'kids',
                'descriptions' => 'Program lanjutan untuk anak-anak yang sudah memiliki dasar bahasa Inggris. Fokus pada speaking dan reading comprehension.',
                'features'     => 'Kelas 3x seminggu|Speaking practice|Reading comprehension|Storytelling session|Sertifikat kelulusan|Progress report bulanan',
                'price'        => 500000,
                'amount'       => 15,
                'is_active'    => true,
            ],
            [
                'name'         => 'English for Teens - Basic',
                'category'     => 'teens',
                'descriptions' => 'Program dasar bahasa Inggris khusus untuk remaja usia 13-17 tahun. Menunjang materi sekolah dan meningkatkan rasa percaya diri berbicara.',
                'features'     => 'Kelas 2x seminggu|Materi penunjang sekolah|Interactive conversation|Public speaking basic|Sertifikat kelulusan|Free placement test',
                'price'        => 400000,
                'amount'       => 20,
                'is_active'    => true,
            ],
            [
                'name'         => 'English for Teens - Conversation',
                'category'     => 'teens',
                'descriptions' => 'Program percakapan aktif untuk remaja. Fokus pada diskusi, presentasi, dan pengucapan (pronunciation) yang tepat.',
                'features'     => 'Kelas 3x seminggu|Speaking & debate practice|Presentation skill|Accent & pronunciation|Sertifikat kelulusan|Daily speaking challenge',
                'price'        => 550000,
                'amount'       => 15,
                'is_active'    => true,
            ],
            [
                'name'         => 'English for Adult - Regular',
                'category'     => 'adult',
                'descriptions' => 'Program bahasa Inggris untuk dewasa dengan metode komunikatif. Cocok untuk pemula yang ingin meningkatkan kemampuan speaking.',
                'features'     => 'Kelas 2x seminggu|Speaking focused|Grammar foundation|Vocabulary building|Sertifikat kelulusan|Grup belajar WhatsApp',
                'price'        => 450000,
                'amount'       => 25,
                'is_active'    => true,
            ],
            [
                'name'         => 'English for Adult - Intensive',
                'category'     => 'adult',
                'descriptions' => 'Program intensif untuk dewasa yang ingin menguasai bahasa Inggris dengan cepat. Fokus pada speaking, writing, dan TOEFL preparation.',
                'features'     => 'Kelas 4x seminggu|TOEFL preparation|Speaking & writing|One-on-one mentoring|Sertifikat kelulusan|Mock test TOEFL|Materi digital lengkap',
                'price'        => 750000,
                'amount'       => 15,
                'is_active'    => true,
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
