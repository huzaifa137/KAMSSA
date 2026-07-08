<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_recognition_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('house_number', 6)->index(); // FK → houses.Number
            $table->string('certificate_number', 30)->unique(); // e.g. ITEB-CERT-IT-001-2026
            $table->date('issued_date');
            $table->string('issued_by', 150)->nullable();  // name of signing officer
            $table->string('status', 20)->default('active'); // active | revoked
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_recognition_certificates');
    }
};