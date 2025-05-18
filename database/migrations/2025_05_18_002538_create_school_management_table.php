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
        /*Schema::create('school_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/

        // Parents table
        Schema::create('parents', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id')->unique();
            $table->string('occupation', 100)->nullable();
            $table->text('address')->nullable();
            
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Teachers table
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id')->unique();
            $table->string('nip', 20)->unique();
            $table->string('expertise', 100)->nullable();
            $table->date('join_date');
            $table->string('status', 20)->default('active');
            
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Classes table
        Schema::create('classes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 50);
            $table->string('level', 20);
            $table->uuid('homeroom_teacher_id')->nullable();
            $table->string('academic_year', 9);
            $table->integer('capacity')->nullable();
            
            $table->datetimes();
            $table->foreign('homeroom_teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });

        // Students table
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id')->unique();
            $table->string('nisn', 20)->unique();
            $table->uuid('class_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 50)->nullable();
            $table->text('address')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->date('enrollment_date');
            $table->string('status', 20)->default('active');
            
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
        });

        // Staff table
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id')->unique();
            $table->string('position', 100);
            $table->string('department', 100)->nullable();
            $table->date('join_date');
            $table->string('status', 20)->default('active');
            
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Subjects table
        Schema::create('subjects', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('credit_hours')->nullable();
            
            $table->datetimes();
        });

        // Class-Subject relationship
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('class_id');
            $table->uuid('subject_id');
            $table->uuid('teacher_id')->nullable();
            $table->text('schedule_info')->nullable();
            $table->unique(['class_id', 'subject_id']);
            
            $table->datetimes();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });

        // Schedules table
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('class_subject_id');
            $table->smallInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room', 50)->nullable();
            
            $table->datetimes();
            $table->foreign('class_subject_id')->references('id')->on('class_subjects')->onDelete('cascade');
        });

        // School Inventory table
        Schema::create('school_inventory', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 100);
            $table->string('category', 50);
            $table->integer('quantity');
            $table->string('location', 100)->nullable();
            $table->string('condition', 50)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('last_maintenance')->nullable();
            
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('class_subjects');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('parents');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('school_inventory');
    }
};
