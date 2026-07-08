<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * An Examination Category is the top-level grouping the client sets up,
     * e.g. "Islamic Mock Examination", "Primary Mock Examination",
     * "Secondary Mock Examination". Each category owns one or more
     * Examination Levels (see examination_levels table) which is what
     * actually populates the dropdowns across the system
     * (Idaad/Thanawi, PLE, UCE/UACE, etc.)
     */
    public function up(): void
    {
        Schema::create('examination_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // e.g. "Islamic Mock Examination"
            $table->string('code')->unique();        // e.g. ISLAMIC_MOCK, PRIMARY_MOCK, SECONDARY_MOCK
            $table->string('name_ar')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examination_categories');
    }
};
