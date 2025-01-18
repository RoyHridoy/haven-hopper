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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');
            $table->integer('total_guests');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('discount')->default(0);
            $table->float('tax')->default(0);
            $table->integer('convenience_fee')->default(0);
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
