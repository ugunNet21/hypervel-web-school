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
        /*Schema::create('elearning', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/
        // Virtual Classes
        Schema::create('virtual_classes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('class_id')->nullable();
            $table->uuid('subject_id')->nullable();
            $table->uuid('teacher_id')->nullable();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('code', 10)->unique();
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->datetimes();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });

        // Learning Materials
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('virtual_class_id');
            $table->string('title', 200);
            $table->text('content')->nullable();
            $table->string('file_url', 255)->nullable();
            $table->string('material_type', 50);
            $table->boolean('is_published')->default(false);
            $table->timestamp('publish_date')->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('virtual_class_id')->references('id')->on('virtual_classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Assignments
        Schema::create('assignments', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('virtual_class_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->timestamp('due_date');
            $table->integer('max_score')->nullable();
            $table->boolean('is_published')->default(false);
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('virtual_class_id')->references('id')->on('virtual_classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Quizzes
        Schema::create('quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('virtual_class_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->integer('time_limit_minutes')->nullable();
            $table->integer('max_attempts')->default(1);
            $table->boolean('is_published')->default(false);
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('virtual_class_id')->references('id')->on('virtual_classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Discussions
        Schema::create('discussions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('virtual_class_id');
            $table->string('title', 200);
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('virtual_class_id')->references('id')->on('virtual_classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Discussion Replies
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('discussion_id');
            $table->text('content');
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Video Conferences
        Schema::create('video_conferences', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('virtual_class_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->string('meeting_id', 100);
            $table->string('meeting_password', 50)->nullable();
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('virtual_class_id')->references('id')->on('virtual_classes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('video_conferences');
        Schema::dropIfExists('discussion_replies');
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('learning_materials');
        Schema::dropIfExists('virtual_classes');
    }
};
