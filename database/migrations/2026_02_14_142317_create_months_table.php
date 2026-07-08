<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('months', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('ID');

            $table->string('Month', 45);

            $table->unique('Month', 'Index_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('months');
    }
};
