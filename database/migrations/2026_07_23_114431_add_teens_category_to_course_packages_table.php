<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE course_packages MODIFY COLUMN category ENUM('kids', 'teens', 'adult') DEFAULT 'adult'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE course_packages MODIFY COLUMN category ENUM('kids', 'adult') DEFAULT 'adult'");
    }
};
