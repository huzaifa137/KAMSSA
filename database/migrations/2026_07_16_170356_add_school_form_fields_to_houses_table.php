<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            // Add new columns for the form fields
            $table->string('administrator_names')->nullable()->after('ContactPerson');
            $table->string('administrator_telephones')->nullable()->after('administrator_names');
            $table->string('title')->nullable()->after('administrator_telephones');
            $table->string('category')->nullable()->after('title');
            $table->string('district')->nullable()->after('category');
        });
    }

    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn([
                'administrator_names',
                'administrator_telephones',
                'title',
                'category',
                'district',
            ]);
        });
    }
};