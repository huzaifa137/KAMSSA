<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students_basic', function (Blueprint $table) {

            // Primary Key
            $table->string('Student_ID', 25)->primary();

            $table->string('Student_Name', 100);
            $table->date('Date_of_Birth')->nullable();
            $table->string('Student_Name_AR', 45)->nullable();
            $table->string('StudentSex_AR', 45)->nullable();
            $table->string('District_AR', 100)->nullable();
            $table->string('MothersJob', 100)->nullable();
            $table->string('Disabilities', 100)->nullable();
            $table->string('ChronicleDiseases', 100)->nullable();
            $table->string('Birth_Place', 45)->nullable();
            $table->string('Birth_Place_AR', 45)->nullable();
            $table->string('Date_of_Birth_AR', 45)->nullable();
            $table->string('StudentsAddress', 50)->nullable();
            $table->string('FathersAddress', 45)->nullable();
            $table->string('MothersAddress', 45)->nullable();
            $table->string('GuardianAddress', 45)->nullable();
            $table->string('Fatherscontact', 45)->nullable();
            $table->string('MothersContact', 45)->nullable();
            $table->dateTime('EntryDate')->nullable();
            $table->string('GuardiansContact', 45)->nullable();
            $table->string('GuardiansJob', 45)->nullable();
            $table->string('FathersNationality', 45)->nullable();
            $table->string('MothersNationality', 45)->nullable();
            $table->string('GuardiansNationality', 45)->nullable();
            $table->string('StudentsNationality', 45)->nullable();
            $table->string('StudentsCitizenship', 45)->nullable();
            $table->string('FathersCitizenship', 45)->nullable();
            $table->string('MothersCitizenship', 45)->nullable();
            $table->string('GuardiansCitizenship', 45)->nullable();
            $table->string('StudentSex', 45)->nullable();
            $table->string('StudentSurname', 45)->nullable();
            $table->string('StudentFirstname', 45)->nullable();
            $table->string('OtherNames', 45)->nullable();
            $table->string('GuardianRelationship', 45)->nullable();
            $table->string('GuardianName', 45)->nullable();
            $table->string('IsOrphan', 45)->nullable();
            $table->unsignedInteger('admnno')->nullable();
            $table->unsignedInteger('admnyr')->nullable();
            $table->unsignedInteger('admncl')->nullable();
            $table->string('FatherStatus', 45)->nullable();
            $table->string('MotherStatus', 45)->nullable();
            $table->string('Photo', 255)->nullable();
            $table->string('District', 45)->nullable();
            $table->string('Class', 45)->nullable();
            $table->string('Section', 45)->nullable();
            $table->string('Class_AR', 45)->nullable();
            $table->string('state', 45)->default('Active');
            $table->string('classid', 45)->nullable();
            $table->string('House', 45)->nullable();
            $table->string('ID_AR', 45)->nullable();
            $table->unsignedInteger('SNO')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students_basic');
    }
};
