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

        // Marketplace Products
        Schema::create('marketplace_products', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category', 50);
            $table->integer('stock_quantity');
            $table->string('image_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->datetimes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id');
            $table->string('transaction_type', 50);
            $table->decimal('amount', 10, 2);
            $table->string('payment_method', 50);
            $table->string('status', 20);
            $table->string('reference_id', 100)->nullable();
            $table->text('description')->nullable();
            $table->datetimes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Transaction Items
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('transaction_id');
            $table->uuid('product_id')->nullable();
            $table->string('item_type', 50);
            $table->string('description', 200);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->datetimes();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('marketplace_products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('marketplace_products');
    }
};
