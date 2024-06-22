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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->tinyInteger('people');
            $table->tinyInteger('table');
            $table->string('status');
            $table->string('snap_token')->nullable();
            $table->integer('down_payment')->nullable();
            $table->integer('total_price')->nullable();
            $table->date('date');
            $table->time('time');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
