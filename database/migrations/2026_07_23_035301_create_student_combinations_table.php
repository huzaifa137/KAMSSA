<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_combinations', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 50);        // e.g. IT-002-UACE-004-2026
            $table->unsignedBigInteger('combination_id');
            $table->string('category', 10);          // UACE (kept explicit, mirrors
                                                       // student_subject_registrations)
            $table->string('year', 4);
            $table->string('school_number', 30)->nullable();
            $table->timestamps();

            // A student can only be in ONE combination per sitting/year.
            $table->unique(['student_id', 'year'], 'student_combinations_student_year_unique');
            $table->index(['category', 'year', 'school_number'], 'sc_category_year_school_idx');

            $table->foreign('combination_id')
                ->references('id')->on('combinations')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_combinations');
    }
};