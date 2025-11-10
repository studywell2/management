<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('teacher_attendances', function (Blueprint $table) {
            $table->time('sign_in')->nullable()->after('date');
            $table->time('sign_out')->nullable()->after('sign_in');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_attendances', function (Blueprint $table) {
            $table->dropColumn(['sign_in', 'sign_out']);
        });
    }
};
