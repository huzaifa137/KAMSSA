<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRegistrationSystem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create school_registration_slots table
        Schema::create('school_registration_slots', function (Blueprint $table) {
            $table->id();
            $table->string('school_id');
            $table->integer('admission_year');
            $table->integer('slots_allocated')->default(0);
            $table->integer('slots_used')->default(0);
            $table->boolean('registration_open')->default(false);
            $table->text('notes')->nullable();
            $table->integer('allocated_by')->nullable();
            $table->timestamps();
            $table->unique(['school_id', 'admission_year']);
        });

        // Create school_slot_history table
        Schema::create('school_slot_history', function (Blueprint $table) {
            $table->id();
            $table->string('school_id');
            $table->integer('admission_year');
            $table->integer('slots_added');
            $table->integer('total_after');
            $table->text('reason')->nullable();
            $table->integer('added_by')->nullable();
            $table->timestamps();
        });

        // Create registration_periods table
        Schema::create('registration_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('admission_year');
            $table->dateTime('opens_at')->nullable();
            $table->dateTime('closes_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });

        // Add columns to student_registrations table if they don't exist
        if (Schema::hasTable('student_registrations')) {
            Schema::table('student_registrations', function (Blueprint $table) {
                if (!Schema::hasColumn('student_registrations', 'submitted_at')) {
                    $table->timestamp('submitted_at')->nullable()->after('entry_date');
                }
                if (!Schema::hasColumn('student_registrations', 'is_locked')) {
                    $table->boolean('is_locked')->default(false)->after('submitted_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_slot_history');
        Schema::dropIfExists('school_registration_slots');
        Schema::dropIfExists('registration_periods');

        if (Schema::hasTable('student_registrations')) {
            Schema::table('student_registrations', function (Blueprint $table) {
                $table->dropColumn(['submitted_at', 'is_locked']);
            });
        }
    }
}