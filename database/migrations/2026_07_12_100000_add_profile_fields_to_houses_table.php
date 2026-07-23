<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SchoolController (the "rich school profile" features — Edit School,
     * View School Profile, Change Status, School Options) was written
     * against fields that were never actually added to any table (it
     * referenced a non-existent App\Models\School). Since `houses` is the
     * real, actively-used school entity everywhere else in the app, these
     * extra profile fields belong there — all nullable so existing rows
     * are unaffected.
     *
     * Note: name/registration_code/date_added are NOT duplicated here —
     * House already has House/Number/RegistrationDate for those, and the
     * House model now exposes `name`, `registration_code`, `date_added`
     * as accessors that read from those existing columns instead.
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->unsignedTinyInteger('school_status')->default(1)->after('ContactPerson');
            $table->string('email')->nullable()->after('school_status');
            $table->string('phone')->nullable()->after('email');
            $table->string('school_type')->nullable()->after('phone');
            $table->string('gender')->nullable()->after('school_type');
            $table->string('regional_level')->nullable()->after('gender');
            $table->string('school_ownership')->nullable()->after('regional_level');
            $table->string('boarding_status')->nullable()->after('school_ownership');
            $table->string('school_product')->nullable()->after('boarding_status');
            $table->string('population')->nullable()->after('school_product');
            $table->string('motto')->nullable()->after('population');
            $table->string('vision')->nullable()->after('motto');
            $table->string('admission_prefix')->nullable()->after('vision');
            $table->string('admission_start')->nullable()->after('admission_prefix');
            $table->string('admission_suffix')->nullable()->after('admission_start');
            $table->string('logo')->nullable()->after('admission_suffix');
        });
    }

    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn([
                'school_status', 'email', 'phone', 'school_type', 'gender',
                'regional_level', 'school_ownership', 'boarding_status',
                'school_product', 'population', 'motto', 'vision',
                'admission_prefix', 'admission_start', 'admission_suffix', 'logo',
            ]);
        });
    }
};