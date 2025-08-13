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
            $table->id('fine_id');
            $table->foreignId('borrow_id')
                ->constrained('borrows', 'borrow_id')
                ->onDelete('cascade');
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments', 'payment_id')
                ->onDelete('cascade');
            $table->enum('fine_type', ['overdue', 'lost', 'damage']);
            $table->decimal('amount_per_day', 8, 2);
            $table->text('description')->nullable();
            $table->date('fine_date')->default(now());
            $table->enum('status', ['unpaid', 'paid', 'waived'])->default('unpaid');
            $table->timestamps();
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
