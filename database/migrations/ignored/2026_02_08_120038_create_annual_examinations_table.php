<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('annual_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('examination_name');
            $table->string('examination_classification');
            $table->year('year');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['year', 'examination_name']); // composite unique key

        });
    }

    public function down()
    {
        Schema::dropIfExists('annual_examinations');
    }
};
