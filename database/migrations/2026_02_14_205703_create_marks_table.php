<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->foreignId('subject_id');
            $table->decimal('mark', 5, 2);
            $table->string('year');
            $table->string('category');
            $table->string('school_number');
            $table->timestamps();
            
            // Prevent duplicate marks for same student and subject
            $table->unique(['student_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('marks');
    }
};