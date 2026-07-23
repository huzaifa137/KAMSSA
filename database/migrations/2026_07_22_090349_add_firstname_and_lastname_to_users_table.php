<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * The System Users (Marks Entrant CRUD) feature reads/writes
 * users.firstname and users.lastname, but the original users table
 * migration only ever created a single `name` column. Add the two
 * missing columns here rather than editing the original migration
 * (which may already be run in other environments).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'firstname')) {
                $table->string('firstname', 100)->nullable()->after('username');
            }
            if (!Schema::hasColumn('users', 'lastname')) {
                $table->string('lastname', 100)->nullable()->after('firstname');
            }
        });

        // Best-effort backfill for any existing users so the edit modal
        // isn't blank for accounts created before this migration ran.
        DB::table('users')
            ->whereNull('firstname')
            ->orderBy('id')
            ->get(['id', 'name'])
            ->each(function ($user) {
                $parts = preg_split('/\s+/', trim((string) $user->name), 2);
                DB::table('users')->where('id', $user->id)->update([
                    'firstname' => $parts[0] ?? '',
                    'lastname' => $parts[1] ?? '',
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'firstname')) {
                $table->dropColumn('firstname');
            }
            if (Schema::hasColumn('users', 'lastname')) {
                $table->dropColumn('lastname');
            }
        });
    }
};