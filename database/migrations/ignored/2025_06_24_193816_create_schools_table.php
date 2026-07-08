<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_type');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('regional_level');
            $table->string('school_ownership');
            $table->string('boarding_status');
            $table->string('name');
            $table->string('school_product');
            $table->string('registration_code')->unique();
            $table->string('phone');
            $table->integer('school_status')->default(1);
            $table->string('population');
            $table->integer('added_by')->nullable();
            $table->string('date_added')->nullable();
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
