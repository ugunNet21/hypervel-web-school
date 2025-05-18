<?php

declare (strict_types = 1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hypervel\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*Schema::create('online_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/

        // Question Bank
        Schema::create('question_bank', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('subject_id');
            $table->string('question_type', 50);
            $table->string('difficulty_level', 20)->nullable();
            $table->text('question_text');
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->text('explanation')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Exams
        Schema::create('exams', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 100);
            $table->string('exam_type', 20);
            $table->uuid('subject_id')->nullable();
            $table->uuid('class_id')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('duration_minutes');
            $table->decimal('passing_grade', 5, 2)->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('proctoring_enabled')->default(false);
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Exam Questions
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('exam_id');
            $table->uuid('question_id');
            $table->decimal('points', 5, 2);
            $table->integer('question_order');
            $table->datetimes();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('question_bank')->onDelete('cascade');
        });

        // Exam Results
        Schema::create('exam_results', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('exam_id');
            $table->uuid('student_id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->string('passing_status', 20)->nullable();
            $table->text('proctoring_notes')->nullable();
            $table->datetimes();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        // Exam Answers
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('exam_result_id');
            $table->uuid('question_id');
            $table->text('answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->datetimes();
            $table->foreign('exam_result_id')->references('id')->on('exam_results')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('question_bank')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('exam_answers');
        Schema::dropIfExists('exam_results');
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('question_bank');
    }
};
