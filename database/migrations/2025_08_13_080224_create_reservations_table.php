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
            $table->id('reservation_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('book_id')
                ->constrained('books', 'book_id')
                ->onDelete('cascade');
            $table->dateTime('reservation_date')->default(now());
            $table->dateTime('expiry_date');
            $table->enum('status', ['active', 'fulfilled', 'expired', 'cancelled'])->default('active');
            $table->integer('priority_number')->unsigned();
            $table->boolean('notification_sent')->default(false);
            $table->timestamps();
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
