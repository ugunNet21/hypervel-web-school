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

        // AI Tutor Sessions
        Schema::create('ai_tutor_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id');
            $table->uuid('subject_id')->nullable();
            $table->string('session_topic', 200);
            $table->json('conversation_history')->nullable();
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->nullable();
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
        });

        // Career Assessments
        Schema::create('career_assessments', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->string('assessment_type', 50);
            $table->date('assessment_date');
            $table->json('results')->nullable();
            $table->text('recommendations')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Counseling Sessions
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('student_id');
            $table->uuid('counselor_id');
            $table->date('session_date');
            $table->time('session_time');
            $table->integer('duration_minutes');
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->datetimes();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('counselor_id')->references('id')->on('teachers')->onDelete('cascade');
        });

        // Industry Partners
        Schema::create('industry_partners', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 100);
            $table->string('industry', 50);
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->text('partnership_details')->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('industry_partners');
        Schema::dropIfExists('counseling_sessions');
        Schema::dropIfExists('career_assessments');
        Schema::dropIfExists('ai_tutor_sessions');
    }
};
