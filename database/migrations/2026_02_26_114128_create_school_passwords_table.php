<?php
// database/migrations/2024_01_01_000000_create_school_passwords_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolPasswordsTable extends Migration
{
    public function up()
    {
        Schema::create('school_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('school_id', 6)->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('password_plain'); // Plain text password for sharing
            $table->string('password_hashed'); // Hashed password for authentication
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('school_id')
                ->references('Number')
                ->on('houses')
                ->onDelete('cascade');

            // Ensure one password per school
            $table->unique('school_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_passwords');
    }
}