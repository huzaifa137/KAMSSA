<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A broadcast message is one composed notification sent out by a system
 * user (Administrator) to any mix of Schools (houses table) and/or other
 * System Users (users table). Who actually received it lives in
 * broadcast_message_recipients — this table only holds the content and
 * a human-readable summary of who it was aimed at.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('broadcast_messages', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('body');
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();

            // Schools and System Users are chosen independently, e.g. "All
            // Schools" + "3 selected System Users" in the same message.
            $table->enum('schools_mode', ['none', 'all', 'selected'])->default('none');
            $table->enum('users_mode', ['none', 'all', 'selected'])->default('none');

            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');

            // Denormalized so the sent-messages list doesn't need a join/count on every row.
            $table->unsignedInteger('recipients_count')->default(0);
            $table->unsignedInteger('schools_count')->default(0);
            $table->unsignedInteger('users_count')->default(0);

            $table->timestamps();

            $table->index(['sender_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_messages');
    }
};
