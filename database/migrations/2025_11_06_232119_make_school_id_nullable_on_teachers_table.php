<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('teachers', function (Blueprint $table) {
        $table->unsignedBigInteger('school_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('teachers', function (Blueprint $table) {
        $table->unsignedBigInteger('school_id')->nullable(false)->change();
    });
}

};
