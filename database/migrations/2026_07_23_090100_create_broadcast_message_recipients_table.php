<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One row = "this school (houses.ID) or this system user (users.id) is a
 * recipient of this broadcast message". Kept as a light two-column
 * polymorphic pair (recipient_type/recipient_id) rather than a real
 * Eloquent polymorphic relation because houses uses a non-standard
 * primary key ("ID"), which morphTo() cannot resolve on its own.
 *
 * is_read / read_at let both the School portal and the admin's own inbox
 * show unread badges and let the sender see delivery/read receipts.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('broadcast_message_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broadcast_message_id')->constrained('broadcast_messages')->cascadeOnDelete();

            $table->enum('recipient_type', ['school', 'user']);
            $table->unsignedBigInteger('recipient_id'); // houses.ID or users.id, depending on recipient_type

            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['broadcast_message_id', 'recipient_type', 'recipient_id'],
                'bmr_message_recipient_unique'
            );
            $table->index(
                ['recipient_type', 'recipient_id', 'is_read'],
                'bmr_recipient_read_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_message_recipients');
    }
};
