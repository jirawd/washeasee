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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('laundry_shop_id');
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('laundry_shop_id')->references('id')->on('users');
            $table->foreign('rider_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
