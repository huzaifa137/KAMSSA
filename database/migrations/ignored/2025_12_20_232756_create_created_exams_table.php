<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatedExamsTable extends Migration
{
    public function up()
    {
        Schema::create('created_exams', function (Blueprint $table) {
            $table->id();
            $table->text('ce_exam_name');
            $table->integer('ce_term');
            $table->json('ce_class_ids');
            $table->text('ce_exam_year')->nullable();;
            $table->text('ce_created_by')->nullable();
            $table->text('ce_date_created')->nullable();
            $table->integer('ce_exam_status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('created_exams');
    }
}
