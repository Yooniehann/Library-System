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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->text('message'); // Feedback content
            $table->timestamp('submitted_at')->useCurrent(); // Defaults to current timestamp
            $table->enum('status', [
                'Pending',
                'Reviewed'
            ])->default('Pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade'); // or 'restrict' based on your needs

            // Index for performance
            $table->index(['status', 'submitted_at']); // Helps filter feedback by status and date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
