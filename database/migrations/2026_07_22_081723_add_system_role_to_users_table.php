<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * `system_role` is only meaningful for users whose `user_role` is
     * 'admin' (i.e. it never applies to students). It lets us keep the
     * existing admin login flow completely untouched while still telling
     * "full administrator" (system_role = null) apart from a restricted
     * "marks_entrant" account that should only see the subjects/papers
     * assigned to them.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('system_role', 30)->nullable()->after('user_role');
            $table->index('system_role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['system_role']);
            $table->dropColumn('system_role');
        });
    }
};
