<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * An Examination Level belongs to an Examination Category and is what
     * ends up inside every dropdown across the system.
     *
     * Examples:
     *   Category: Secondary Mock Examination -> Levels: UCE (O-LEVEL), UACE (A-LEVEL)
     *   Category: Primary Mock Examination -> Levels: PLE
     *   Category: Secondary Mock Examination -> Levels: UCE, UACE
     */
    public function up(): void
    {
        Schema::create('examination_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_category_id')
                ->constrained('examination_categories')
                ->cascadeOnDelete();

            $table->string('name');          // e.g. "UCE (O-LEVEL)", "Uganda Certificate of Education"
            $table->string('name_ar')->nullable();
            $table->string('short_code', 20); // e.g. ID, TH, PLE, UCE, UACE - used as the option value
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['examination_category_id', 'short_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examination_levels');
    }
};
