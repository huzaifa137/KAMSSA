<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('firstname');
            $table->string('lastname');
            $table->string('senior');
            $table->string('stream');
            $table->string('registration_number')->nullable()->unique();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->bigInteger('school_id');

            // Optional but important fields
            $table->string('admission_number')->unique()->nullable();
            $table->string('primary_contact')->nullable();
            $table->string('other_contact')->nullable();
            $table->string('student_photo')->nullable(); // path to photo file
            $table->date('date_of_admission')->nullable();
            $table->decimal('ple_score', 5, 2)->nullable();
            $table->decimal('uce_score', 5, 2)->nullable();
            $table->string('previous_school')->nullable();
            $table->string('primary_school_name')->nullable();
            $table->string('guardian_names')->nullable();
            $table->string('relation')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_email')->nullable();
            $table->text('home_address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('birth_certificate_entry_number')->nullable();
            $table->string('nationality')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('comments')->nullable();
            $table->string('added_by')->nullable(); // could be user ID or name

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
