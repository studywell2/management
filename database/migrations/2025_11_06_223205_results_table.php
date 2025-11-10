<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

            // Student details
            $table->string('student_name');
            $table->string('class')->nullable();

            // Result details
            $table->integer('score');
            $table->string('grade', 2);
            $table->string('term');
            $table->string('session', 10);

            $table->timestamps();

            // Optional: prevent duplicates for same student/subject/term/session
            $table->unique(['student_id', 'subject_id', 'term', 'session'], 'unique_result_per_term');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
