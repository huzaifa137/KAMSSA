<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * One row = "this user may enter marks for this subject's paper".
     *
     * subject_id refers to master_datas.md_id (the same subject identifier
     * used by `marks`, `mark_papers` and `subject_papers` — see the
     * comment in 2026_07_12_110000_create_subject_papers_table.php).
     *
     * A subject with only one paper gets a single row with paper_number=1.
     * A multi-paper subject (e.g. Math P1/P2) gets one row per paper the
     * entrant is allowed to capture — so an entrant can be trusted with
     * P1 only, P2 only, or both, independently.
     */
    public function up(): void
    {
        Schema::create('marks_entrant_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subject_id'); // master_datas.md_id
            $table->unsignedTinyInteger('paper_number')->default(1);
            $table->string('category', 10)->nullable(); // PLE / UCE / UACE, denormalized for fast lookups
            $table->timestamps();

            $table->unique(
                ['user_id', 'subject_id', 'paper_number'],
                'mea_user_subject_paper_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks_entrant_assignments');
    }
};