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
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('stream_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('compute_status')->default(1);
            $table->unsignedBigInteger('exam_id');
            $table->decimal('marks', 5, 2)->nullable();

            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('uploaded_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
