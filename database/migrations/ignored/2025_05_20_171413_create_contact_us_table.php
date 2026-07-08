<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->text('student_email');
            $table->text('student_subject');
            $table->text('student_message');
            $table->integer('student_id');
            $table->integer('admin_response_status')->default(0);
            $table->text('admin_response_message');
            $table->integer('admin_responded_by')->nullable();
            $table->text('date_added')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
