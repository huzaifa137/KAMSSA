<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_stream_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('stream_id');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->String('date_added')->nullable();
            $table->timestamps();

            // $table->unique(['class_id', 'stream_id']);

            // Optional: Foreign key constraints if you have 'classes' and 'streams' tables

            // $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            // $table->foreign('stream_id')->references('id')->on('streams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_stream_assignments');
    }
};
