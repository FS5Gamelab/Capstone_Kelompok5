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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('product_name');
            $table->string('slug')->unique()->nullable();
            $table->string('type');
            $table->text('description');
            $table->integer('price');
            $table->string('product_image')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('products');
    }
};
