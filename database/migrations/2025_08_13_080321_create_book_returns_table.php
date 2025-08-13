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
        Schema::create('book_returns', function (Blueprint $table) {
            $table->id('return_id');
            $table->foreignId('borrow_id')
                ->constrained('borrows', 'borrow_id')
                ->onDelete('cascade');
            $table->foreignId('staff_id')
                ->constrained('staff', 'staff_id')
                ->onDelete('cascade');
            $table->dateTime('return_date')->default(now());
            $table->enum('condition_on_return', ['excellent', 'good', 'fair', 'poor', 'damaged']);
            $table->unsignedInteger('late_days')->default(0);
            $table->decimal('fine_amount', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_returns');
    }
};
