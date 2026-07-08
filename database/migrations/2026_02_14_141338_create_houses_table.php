<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            // If you want latin1 like original SQL
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('ID');

            $table->string('House', 255);
            $table->text('House_AR')
                  ->charset('utf8');

            $table->string('Number', 6)->unique();
            $table->string('Location', 100);

            // Timestamp with CURRENT_TIMESTAMP ON UPDATE
            $table->timestamp('RegistrationDate')
                  ->useCurrent()
                  ->useCurrentOnUpdate();

            $table->unsignedInteger('Head')->default(0);
            $table->unsignedInteger('ContactPerson')->default(0);

            $table->unique('House', 'Index_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
