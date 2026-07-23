<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Stores the individual paper mark for subjects that have more than
     * one paper (e.g. Mathematics P1/P2, Fine Art P1-P5).
     *
     * The existing `marks` table is untouched and keeps storing ONE row
     * per (student_id, subject_id) as before — its `mark` value is simply
     * the AVERAGE of all rows saved here for that student+subject. This
     * means every existing consumer of `marks` (grading, passslips,
     * certificates, analytics, exam statistics) keeps working with zero
     * changes — they never need to know a subject has multiple papers.
     */
    public function up()
    {
        Schema::create('mark_papers', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->foreignId('subject_id');
            $table->unsignedTinyInteger('paper_number')->default(1);
            $table->decimal('mark', 5, 2);
            $table->string('year');
            $table->string('category');
            $table->string('school_number');
            $table->timestamps();

            // One mark per (student, subject, paper)
            $table->unique(
                ['student_id', 'subject_id', 'paper_number'],
                'mark_papers_student_subject_paper_unique'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('mark_papers');
    }
};