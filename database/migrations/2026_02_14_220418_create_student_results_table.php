<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('year');
            $table->string('category');
            $table->string('school_number');
            $table->decimal('total_marks', 8, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->string('grade')->nullable();
            $table->string('classification')->nullable();
            $table->string('level')->default('A');
            $table->timestamps();
            
            $table->unique(['student_id', 'year', 'category']); // Prevent duplicates
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_results');
    }
};