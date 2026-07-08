<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('submission_documents', function (Blueprint $table) {
            $table->id();
            $table->string('submission_batch_id')->nullable();
            $table->string('file_name');
            $table->string('original_name')->nullable();
            $table->string('file_path');
            $table->string('file_type');
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size');
            $table->json('student_ids');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->string('storage_disk')->default('public');
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('school_id');
            $table->index('submitted_by');
            $table->index('submission_batch_id');
            $table->index('created_at');
            $table->index('uploaded_at');
            
            // Foreign keys
            // $table->foreign('school_id')->references('ID')->on('houses')->onDelete('cascade');
            // $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submission_documents');
    }
}