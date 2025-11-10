<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('results', function (Blueprint $table) {
            if (!Schema::hasColumn('results', 'student_name')) {
                $table->string('student_name')->after('student_id');
            }

            if (!Schema::hasColumn('results', 'class')) {
                $table->string('class')->nullable()->after('student_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['student_name', 'class']);
        });
    }
};
