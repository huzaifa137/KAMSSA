<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmissionDocumentIdToStudentRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('submission_document_id')->nullable()->after('status');
            $table->foreign('submission_document_id')
                  ->references('id')
                  ->on('submission_documents')
                  ->onDelete('set null');
            $table->index('submission_document_id');
        });
    }

    public function down()
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropForeign(['submission_document_id']);
            $table->dropColumn('submission_document_id');
        });
    }
}