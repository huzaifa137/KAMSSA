<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            // Match original SQL charset
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            // Primary key (varchar)
            $table->string('ID', 45)->primary();

            $table->string('Level', 45)->nullable();

            $table->boolean('Available')->default(0);

            $table->string('Level_ar', 45)
                  ->charset('utf8')
                  ->nullable();

            $table->unique('Level', 'Index_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
