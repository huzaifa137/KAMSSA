<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This table is intentionally kept as a single-row ("singleton") table.
     * Whenever a new client is onboarded, this one row is updated (name,
     * acronym, logo, contact details, etc.) and the change is reflected
     * everywhere in the system automatically because every view pulls
     * from this table through the SystemSetting model / helper.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('system_name')->default('Kampala Integrated Secondary Schools Examination');
            $table->string('system_name_ar')->nullable();
            $table->string('short_name', 30)->default('KAMSSA'); // acronym e.g. KAMSSA, KAMSSA
            $table->string('tagline')->nullable();

            // Branding
            $table->string('logo_path')->nullable();      // main logo used in headers/certificates
            $table->string('favicon_path')->nullable();
            $table->string('letterhead_path')->nullable(); // optional letterhead/cert background

            // Contact / address
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Footer / misc text shown across the system
            $table->text('footer_text')->nullable();
            $table->text('portal_welcome_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
