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
        /*Schema::create('digital_library', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetimes();
        });*/

        // Books
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('isbn', 20)->nullable();
            $table->string('title', 200);
            $table->string('author', 100);
            $table->string('publisher', 100)->nullable();
            $table->integer('publication_year')->nullable();
            $table->string('category', 50);
            $table->integer('quantity')->default(1);
            $table->integer('available_quantity')->default(1);
            $table->string('cover_url', 255)->nullable();
            $table->text('description')->nullable();
            $table->datetimes();
        });

        // Ebook Formats
        Schema::create('ebook_formats', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('book_id');
            $table->string('format', 10);
            $table->string('file_url', 255);
            $table->bigInteger('file_size')->nullable();
            $table->datetimes();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        // Book Loans
        Schema::create('book_loans', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('book_id');
            $table->uuid('borrower_id');
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->string('status', 20)->default('borrowed');
            $table->datetimes();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('borrower_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Book Reviews
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('book_id');
            $table->uuid('reviewer_id');
            $table->smallInteger('rating');
            $table->text('review_text')->nullable();
            $table->boolean('is_public')->default(true);
            $table->datetimes();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('book_reviews');
        Schema::dropIfExists('book_loans');
        Schema::dropIfExists('ebook_formats');
        Schema::dropIfExists('books');
    }
};
