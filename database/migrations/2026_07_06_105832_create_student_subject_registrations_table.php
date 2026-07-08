<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_subject_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 50);           // e.g. IT-001-UCE-014-2025
            $table->unsignedBigInteger('subject_id');    // master_datas.md_id
            $table->string('category', 10);              // UCE, UACE (extensible to others later)
            $table->string('year', 4);
            $table->boolean('is_compulsory')->default(false);
            $table->string('school_number', 30)->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'year'], 'ssr_student_subject_year_unique');
            $table->index(['category', 'year', 'school_number'], 'ssr_category_year_school_idx');
            $table->index('subject_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_subject_registrations');
    }
};