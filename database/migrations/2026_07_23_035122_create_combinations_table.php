<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);          // e.g. PCM, HEG
            $table->string('name', 150);         // e.g. Physics, Chemistry, Mathematics
            $table->string('category', 10);      // UACE (kept as a column, not hardcoded,
            // so PLE/other future combination-based
            // categories don't need a schema change)
            $table->string('status', 20)->default('Active'); // Active / Inactive — same
            // convention as master_datas.md_misc2
            $table->timestamps();

            $table->unique(['category', 'code'], 'combinations_category_code_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combinations');
    }
};