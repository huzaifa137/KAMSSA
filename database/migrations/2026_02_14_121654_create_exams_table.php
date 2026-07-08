<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {

            $table->unsignedInteger('id');
            $table->date('ExamDate');
            $table->string('Venue', 45);
            $table->unsignedInteger('ETime')->nullable();
            $table->string('Class', 45)->nullable();
            $table->string('PaperCode', 45);
            $table->double('Duration')->default(0);
            $table->string('ExamFile', 10);
            $table->string('Facilitator', 45);
            $table->string('ExTime', 15);
            $table->float('Weight');
            $table->string('GenClass', 45)->nullable();
            $table->string('ExamType', 45);
            $table->boolean('Status');
            $table->string('Stream', 45)->nullable();
            $table->string('AssesmentTitle', 45)->nullable();

            // utf8 column
            $table->string('ExamDate_Ar', 45)
                ->charset('utf8')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
