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
        Schema::create('registration_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->enum('program_category', ['kids', 'adult']);
            $table->string('name');
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('domicile')->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->string('parent_phone')->nullable();
            $table->timestamps();

            $table->unique('registration_id');
        });

        // Add check constraint to ensure required phone depending on program_category.
        // If DB doesn't support CHECK or fails, we ignore the error to keep migration portable.
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
        } catch (\Exception $e) {
            // ignore - not all MySQL versions enforce or support CHECK constraints
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE registration_details DROP CHECK chk_registration_details_phone');
        } catch (\Exception $e) {
            // ignore
        }

        Schema::dropIfExists('registration_details');
    }
};
