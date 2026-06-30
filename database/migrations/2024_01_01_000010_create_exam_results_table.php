<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('exam_name');
            $table->decimal('marks_obtained', 5, 2);
            $table->integer('total_marks')->default(100);
            $table->string('grade')->nullable();
            $table->date('exam_date');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'exam_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
