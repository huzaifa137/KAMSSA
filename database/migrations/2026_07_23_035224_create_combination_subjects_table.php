<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('combination_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combination_id');
            $table->unsignedBigInteger('subject_id'); // master_datas.md_id
            $table->timestamps();

            $table->unique(['combination_id', 'subject_id'], 'combination_subjects_unique');
            $table->index('subject_id');

            $table->foreign('combination_id')
                ->references('id')->on('combinations')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combination_subjects');
    }
};