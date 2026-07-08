<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translation', function (Blueprint $table) {
            $table->increments('ID');               // Primary key, auto-increment
            $table->integer('NUMBERS')->nullable();  // Integer values, can be NULL
            $table->text('STRINGS')->nullable();     // Various string formats (dates, numbers, text)
            $table->text('TRANSLATION')->nullable(); // Arabic translations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation');
    }
};
