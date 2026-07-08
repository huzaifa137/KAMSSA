<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_allocation', function (Blueprint $table) {

            $table->increments('ID');

            $table->string('Student_ID', 45);
            $table->string('Class_ID', 45)->nullable();
            $table->string('Comment', 100)->nullable();
            $table->string('HeadTeacher', 100)->nullable();
            $table->string('Warden', 100)->nullable();
            $table->integer('Boarding')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_allocation');
    }
};
