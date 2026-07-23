<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Stores the maximum possible raw score for each paper of a subject.
     * e.g. Physics P1 out of 60, P2 out of 40. Defaults to 100 when a
     * subject/paper has no row here (ordinary papers marked out of 100).
     */
    public function up()
    {
        Schema::create('subject_papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id'); // master_datas.md_id
            $table->unsignedTinyInteger('paper_number')->default(1);
            $table->decimal('max_score', 6, 2)->default(100);
            $table->timestamps();

            $table->unique(['subject_id', 'paper_number'], 'subject_papers_subject_paper_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_papers');
    }
};