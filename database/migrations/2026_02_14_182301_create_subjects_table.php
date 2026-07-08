<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {

            $table->increments('ID'); // auto increment primary key

            $table->string('PaperCode', 10)->unique();
            $table->string('Level', 5);
            $table->string('Category', 45);
            $table->string('CategoryName', 45);
            $table->text('subject')->nullable();
            $table->string('SubjectCode', 10);
            $table->string('PaperName', 45)->nullable();
            $table->string('SchoolCategory', 50)->nullable();
            $table->string('SUBJECT_AR', 100)->nullable();
            $table->string('PAPER_AR', 100)->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
