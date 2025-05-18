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
       /* Schema::create('ppdb', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/

        // PPDB Registrations
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('registration_number', 20)->unique();
            $table->string('full_name', 100);
            $table->date('birth_date');
            $table->string('birth_place', 50);
            $table->string('gender', 10);
            $table->string('parent_name', 100);
            $table->string('parent_phone', 20);
            $table->text('address');
            $table->string('previous_school', 100)->nullable();
            $table->string('intended_class', 50);
            $table->string('status', 20)->default('pending');
            $table->timestamp('registration_date')->useCurrent();
            
            $table->datetimes();
        });

        // PPDB Documents
        Schema::create('ppdb_documents', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('registration_id');
            $table->string('document_type', 50);
            $table->string('file_url', 255);
            $table->string('verification_status', 20)->default('pending');
            $table->uuid('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable();
            
            $table->datetimes();
            $table->foreign('registration_id')->references('id')->on('ppdb_registrations')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });

        // PPDB Tests
        Schema::create('ppdb_tests', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('registration_id');
            $table->string('test_type', 50);
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('test_date')->nullable();
            $table->uuid('administrator_id')->nullable();
            
            $table->datetimes();
            $table->foreign('registration_id')->references('id')->on('ppdb_registrations')->onDelete('cascade');
            $table->foreign('administrator_id')->references('id')->on('users')->onDelete('set null');
        });

        // PPDB Announcements
        Schema::create('ppdb_announcements', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('registration_id');
            $table->string('announcement_type', 50);
            $table->text('content');
            $table->uuid('published_by')->nullable();
            $table->timestamp('published_at')->useCurrent();
            
            $table->datetimes();
            $table->foreign('registration_id')->references('id')->on('ppdb_registrations')->onDelete('cascade');
            $table->foreign('published_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ppdb_documents');
        Schema::dropIfExists('ppdb_tests');
        Schema::dropIfExists('ppdb_announcements');
        Schema::dropIfExists('ppdb_registrations');
    }
};
