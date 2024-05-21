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
        Schema::create('tbl_carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->unsignedBigInteger('user_id');
            $table->uuid('order_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('total_price')->nullable();
            $table->boolean('checked_out')->default(false);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('product_id')->references('id')->on('tbl_products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_carts');
    }
};
