<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->enum('program_category', ['kids', 'adult'])->nullable()->after('course_package_id');
        });

        // populate program_category from course_packages for existing registrations
        try {
            DB::statement("UPDATE registrations r JOIN course_packages p ON r.course_package_id = p.id SET r.program_category = p.category");
        } catch (\Exception $e) {
            // ignore if update fails for any reason
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('program_category');
        });
    }
};
