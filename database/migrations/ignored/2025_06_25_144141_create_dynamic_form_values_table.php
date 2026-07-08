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
        Schema::create('dynamic_form_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('master_data_id');
            $table->foreign('master_data_id')
                ->references('md_id')
                ->on('master_datas')
                ->onDelete('cascade');

            $table->string('field_name');
            $table->text('field_value')->nullable();
            $table->string('field_type');
            $table->json('field_options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_form_values');
    }
};
