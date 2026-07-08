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
        Schema::create('master_codes', function (Blueprint $table) {
            $table->id();
            $table->string('mc_id');
            $table->string('mc_code');
            $table->string('mc_name');
            $table->string('mc_description');
            $table->string('mc_date_added');
            $table->string('mc_added_by');
            $table->timestamps(0);
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_codes');
    }
};
