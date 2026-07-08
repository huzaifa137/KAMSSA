<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_exam_summaries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('stream_id');
            $table->string('grade')->nullable();
            $table->integer('subjects_count');
            $table->decimal('total_marks', 6, 2);
            $table->decimal('average', 5, 2);
            $table->integer('rank')->nullable();

            $table->unsignedBigInteger('school_id');

            $table->timestamps();

            // $table->unique([
            //     'student_id',
            //     'exam_id',
            //     'class_id',
            //     'school_id'
            // ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam_summaries');
    }
};
