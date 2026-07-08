<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {

            // Primary key (varchar 45)
            $table->string('class_name', 45)->default('');
            $table->primary('class_name');

            $table->string('class', 45);
            $table->unsignedInteger('year');
            $table->integer('term');

            $table->string('class_teacher', 45)->nullable();
            $table->unsignedInteger('Population')->default(0);
            $table->unsignedInteger('Girls')->default(0);
            $table->unsignedInteger('Boys')->default(0);

            $table->string('Stream', 45)->nullable();
            $table->double('Fees')->default(0);
            $table->string('Category', 45)->default('Secular');
            $table->double('BoardingExtras')->default(0);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
