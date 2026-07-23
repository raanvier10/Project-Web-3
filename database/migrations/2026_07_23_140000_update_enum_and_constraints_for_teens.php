<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update ENUM di tabel registrations
        DB::statement("ALTER TABLE registrations MODIFY COLUMN program_category ENUM('kids', 'teens', 'adult') NULL");

        // 2. Update ENUM di tabel registration_details
        DB::statement("ALTER TABLE registration_details MODIFY COLUMN program_category ENUM('kids', 'teens', 'adult') NOT NULL");

        // 3. Drop existing constraint
        try {
            DB::statement('ALTER TABLE registration_details DROP CHECK chk_registration_details_phone');
        } catch (\Exception $e) {
            // Abaikan jika constraint belum ada
        }

        // 4. Create new constraint covering teens
        try {
            DB::statement(<<<'SQL'
ALTER TABLE registration_details
ADD CONSTRAINT chk_registration_details_phone
CHECK (
    (program_category = 'kids' AND parent_phone IS NOT NULL AND parent_phone <> '')
    OR
    (program_category = 'teens' AND phone IS NOT NULL AND phone <> '' AND parent_phone IS NOT NULL AND parent_phone <> '')
    OR
    (program_category = 'adult' AND phone IS NOT NULL AND phone <> '')
)
SQL
            );
        } catch (\Exception $e) {
            // Abaikan jika database versi lama tidak mendukung CHECK constraint
        }
    }

    public function down(): void
    {
        // PERINGATAN: rollback akan menghapus nilai 'teens' jika MySQL mode tidak strict.
        DB::statement("ALTER TABLE registrations MODIFY COLUMN program_category ENUM('kids', 'adult') NULL");
        DB::statement("ALTER TABLE registration_details MODIFY COLUMN program_category ENUM('kids', 'adult') NOT NULL");

        try {
            DB::statement('ALTER TABLE registration_details DROP CHECK chk_registration_details_phone');
        } catch (\Exception $e) {}

        try {
            DB::statement(<<<'SQL'
ALTER TABLE registration_details
ADD CONSTRAINT chk_registration_details_phone
CHECK (
    (program_category = 'kids' AND parent_phone IS NOT NULL AND parent_phone <> '')
    OR
    (program_category = 'adult' AND phone IS NOT NULL AND phone <> '')
)
SQL
            );
        } catch (\Exception $e) {}
    }
};
