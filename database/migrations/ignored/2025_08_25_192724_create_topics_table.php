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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('senior_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('topic_name');
            $table->integer('Competency')->default(0);
            $table->text('topic_description')->nullable();
            $table->timestamp('topic_date_added')->nullable();
            $table->unsignedBigInteger('topic_added_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
