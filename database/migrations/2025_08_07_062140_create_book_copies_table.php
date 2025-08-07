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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id('copy_id'); // Primary key
            $table->unsignedBigInteger('book_id'); // Foreign key to books
            $table->string('unique_code')->unique(); // Unique identifier for each copy
            $table->enum('status', [
                'Available',
                'Borrowed',
                'Reserved',
                'Lost',
                'Damaged'
            ])->default('Available');
            $table->date('added_date')->useCurrent(); // Defaults to current date
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('cascade');

            // Index for better performance on frequently queried fields
            $table->index(['status', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
