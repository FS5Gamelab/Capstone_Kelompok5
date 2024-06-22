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
        Schema::create('reservation_menus', function (Blueprint $table) {
            $table->id();
            $table->uuid('reservation_id')->nullable();
            $table->uuid('product_id')->nullable();
            $table->integer('quantity');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_menus');
    }
};
