<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('school_id');
            $table->string('category');
            $table->integer('admission_year');
            $table->string('student_id');
            $table->string('student_name');
            $table->string('student_name_ar')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('student_sex');
            $table->string('student_nationality')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_place_ar')->nullable();
            $table->string('class')->nullable();
            $table->string('section')->nullable();
            $table->string('house')->nullable();
            $table->string('district')->nullable();
            $table->string('district_ar')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('status')->default('Pending Photo Submission');
            $table->text('admin_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_registrations');
    }
}