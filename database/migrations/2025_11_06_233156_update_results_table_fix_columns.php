<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('results', function (Blueprint $table) {
            if (!Schema::hasColumn('results', 'subject_id')) {
                $table->foreignId('subject_id')->constrained('subjects')->after('student_id');
            }
            if (!Schema::hasColumn('results', 'school_id')) {
                $table->foreignId('school_id')->constrained('schools')->after('subject_id');
            }
            if (!Schema::hasColumn('results', 'student_name')) {
                $table->string('student_name')->after('school_id');
            }
            if (!Schema::hasColumn('results', 'class')) {
                $table->string('class')->nullable()->after('student_name');
            }
            if (!Schema::hasColumn('results', 'score')) {
                $table->integer('score')->after('class');
            }
            if (!Schema::hasColumn('results', 'grade')) {
                $table->string('grade')->after('score');
            }
            if (!Schema::hasColumn('results', 'term')) {
                $table->string('term')->after('grade');
            }
            if (!Schema::hasColumn('results', 'session')) {
                $table->string('session')->after('term');
            }
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['subject_id','school_id','student_name','class','score','grade','term','session']);
        });
    }
};
