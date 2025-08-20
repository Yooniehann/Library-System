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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            $table->foreignId('inventory_id')
                ->constrained('inventories', 'inventory_id')
                ->onDelete('cascade');
            $table->foreignId('staff_id')
                ->constrained('staff', 'staff_id')
                ->onDelete('cascade');
            $table->dateTime('borrow_date')->default(now());
            $table->dateTime('due_date');
            $table->unsignedTinyInteger('renewal_count')->default(0);
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
