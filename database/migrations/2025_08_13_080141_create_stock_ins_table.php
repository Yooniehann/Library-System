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
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id('stockin_id');
            $table->foreignId('supplier_id')
                ->constrained('suppliers', 'supplier_id')
                ->onDelete('cascade');
            $table->foreignId('staff_id')
                ->constrained('staff', 'staff_id')
                ->onDelete('cascade');
            $table->date('stockin_date')->default(now());
            $table->integer('total_books')->unsigned();
            $table->enum('status', ['pending', 'received', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
