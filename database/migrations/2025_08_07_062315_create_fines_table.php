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
        Schema::create('fines', function (Blueprint $table) {
            $table->id('fine_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->unsignedBigInteger('borrow_id'); // Foreign key to borrow_records
            $table->string('reason'); // Reason for the fine (e.g., "Late return", "Damage")
            $table->decimal('amount', 8, 2); // Monetary amount with 2 decimal places
            $table->boolean('paid_status')->default(false); // True if paid, false if unpaid
            $table->date('issued_date')->useCurrent(); // Defaults to current date
            $table->date('paid_date')->nullable(); // Null until fine is paid
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('borrow_id')
                ->references('borrow_id')
                ->on('borrow_records')
                ->onDelete('cascade');

            // Indexes for performance
            $table->index(['paid_status', 'user_id']); // Helps find unpaid fines by user
            $table->index(['issued_date']); // Helps with financial reporting
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
