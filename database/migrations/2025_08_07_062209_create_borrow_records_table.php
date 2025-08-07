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
        Schema::create('borrow_records', function (Blueprint $table) {
            $table->id('borrow_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->unsignedBigInteger('copy_id'); // Foreign key to book_copies
            $table->date('borrow_date')->useCurrent(); // Defaults to current date
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->enum('status', [
                'Borrowed',
                'Returned',
                'Overdue',
                'Lost',
                'Damaged'
            ])->default('Borrowed');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('restrict'); // Prevent deletion if user has borrow records

            $table->foreign('copy_id')
                ->references('copy_id')
                ->on('book_copies')
                ->onDelete('restrict'); // Prevent deletion if copy is borrowed

            // Indexes for performance
            $table->index(['status', 'due_date']); // Helps find overdue books
            $table->index(['user_id', 'status']); // Helps find user's current borrows
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
