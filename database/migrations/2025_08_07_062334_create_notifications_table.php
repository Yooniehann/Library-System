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
            $table->id('notification_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->text('message'); // Notification content
            $table->enum('type', [
                'Due Reminder',
                'Overdue Alert',
                'Reservation Ready',
                'Fine Issued',
                'System Alert'
            ]);
            $table->dateTime('sent_date')->useCurrent(); // Defaults to current timestamp
            $table->boolean('is_read')->default(false); // Unread by default
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade'); // Remove notifications if user is deleted

            // Indexes for performance
            $table->index(['user_id', 'is_read']); // Helps find user's unread notifications
            $table->index(['type', 'sent_date']); // Helps with notification analytics
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
