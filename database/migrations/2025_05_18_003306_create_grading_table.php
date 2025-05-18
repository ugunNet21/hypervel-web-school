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
        /*Schema::create('grading', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/

        // Grades
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->uuid('subject_id');
            $table->uuid('class_id');
            $table->decimal('grade', 5, 2);
            $table->smallInteger('semester');
            $table->string('grade_type', 50);
            $table->uuid('assignment_id')->nullable();
            $table->uuid('quiz_id')->nullable();
            $table->uuid('exam_id')->nullable(); // Foreign key added later
            $table->text('notes')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('set null');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('set null');
        });

        // Competencies
        Schema::create('competencies', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->uuid('subject_id');
            $table->string('competency_code', 20);
            $table->string('competency_name', 100);
            $table->string('achievement_level', 50);
            $table->smallInteger('semester');
            $table->text('notes')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Reports
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->uuid('class_id');
            $table->smallInteger('semester');
            $table->string('academic_year', 9);
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->integer('rank_in_class')->nullable();
            $table->text('homeroom_notes')->nullable();
            $table->text('principal_notes')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Student Portfolios
        Schema::create('student_portfolios', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('file_url', 255)->nullable();
            $table->string('portfolio_type', 50);
            $table->date('date_added');
            $table->boolean('is_public')->default(false);
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('student_portfolios');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('competencies');
        Schema::dropIfExists('grades');
    }
};
