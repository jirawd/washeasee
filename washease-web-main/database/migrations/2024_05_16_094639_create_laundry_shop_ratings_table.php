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
        Schema::create('laundry_shop_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('laundry_shop_id');
            $table->unsignedBigInteger('services_id');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('laundry_shop_id')->references('id')->on('users');
            $table->foreign('services_id')->references('id')->on('services');
            $table->integer('rating_count');
            $table->text('rating_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_shop_ratings');
    }
};