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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->float('rating');
            $table->text('comment')->nullable();
            $table->string('reviewer_type'); // user, owner
            $table->foreignId('review_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete(); // `owner` review against user
            $table->foreignId('rental_id')->nullable()->references('id')->on('rentals')->cascadeOnDelete(); // `user` review against rental
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
