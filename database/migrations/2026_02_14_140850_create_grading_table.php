<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grading', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('ID');

            $table->string('Grade', 20)->nullable();

            $table->float('From');
            $table->float('To');

            $table->string('Comment', 45)
                  ->charset('utf8')
                  ->nullable();

            $table->string('Level', 45);
            $table->float('Weight');
            $table->string('Type', 45);

            $table->unique(['Grade', 'Level'], 'Index_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading');
    }
};
