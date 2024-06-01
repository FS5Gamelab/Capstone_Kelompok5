<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('order_id')->nullable();
            $table->uuid('review_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('cart_total')->nullable();
            $table->boolean('checked_out')->default(false);
            $table->timestamps();


            $table->foreign('product_id')->references('id')->on('products')->onDelete(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
            $table->foreign('review_id')->references('id')->on('reviews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
