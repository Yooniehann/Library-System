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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->enum('notification_type', ['due_reminder', 'overdue', 'fine', 'reservation_ready', 'general']);
            $table->string('title', 100);
            $table->text('message');
            $table->dateTime('sent_date')->default(now());
            $table->enum('delivery_method', ['email', 'sms', 'system']);
            $table->enum('status', ['sent', 'delivered', 'failed'])->default('sent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
