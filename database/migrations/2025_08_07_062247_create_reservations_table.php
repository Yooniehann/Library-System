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
            $table->id('reservation_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->unsignedBigInteger('copy_id'); // Foreign key to book_copies
            $table->dateTime('reservation_date')->useCurrent(); // Defaults to current timestamp
            $table->dateTime('expiration_date'); // When the reservation expires
            $table->enum('status', [
                'Pending',
                'Completed',
                'Canceled'
            ])->default('Pending');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('copy_id')
                ->references('copy_id')
                ->on('book_copies')
                ->onDelete('cascade'); 

            // Indexes for performance
            $table->index(['status', 'expiration_date']); // Helps find expiring reservations
            $table->index(['user_id', 'status']); // Helps find user's active reservations
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
