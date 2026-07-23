<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `mark` continues to store the CONVERTED score on a 0-100 scale
     * (what grading/averaging uses). These two new columns preserve what
     * the teacher actually typed and what it was out of, so re-opening
     * marks entry can show the original raw value instead of the
     * converted one.
     */
    public function up()
    {
        Schema::table('mark_papers', function (Blueprint $table) {
            $table->decimal('raw_mark', 6, 2)->nullable()->after('paper_number');
            $table->decimal('max_score', 6, 2)->default(100)->after('raw_mark');
        });
    }

    public function down()
    {
        Schema::table('mark_papers', function (Blueprint $table) {
            $table->dropColumn(['raw_mark', 'max_score']);
        });
    }
};