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
        Schema::create('master_datas', function (Blueprint $table) {
            $table->increments('md_id');
            $table->integer('md_master_code_id');
            $table->string('md_code');
            $table->string('md_name');
            $table->text('md_description')->nullable();
            $table->string('md_date_added');
            $table->string('md_added_by');
            $table->timestamps();
            $table->string('md_misc1', 255)->nullable();
            $table->string('md_misc2', 255)->nullable();
            $table->string('md_misc3', 255)->nullable();
            $table->string('md_misc4', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_datas');
    }
};
