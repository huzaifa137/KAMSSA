<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grading_settings', function (Blueprint $table) {
            $table->id();
            $table->string('category', 10); // TH, ID, PLE
            $table->string('grade', 20);
            $table->float('from_mark');
            $table->float('to_mark');
            $table->string('comment', 100)->nullable();
            $table->string('type', 20); // Marks or Points
            $table->float('weight')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category', 'grade', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading_settings');
    }
};