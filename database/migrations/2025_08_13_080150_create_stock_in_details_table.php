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
        Schema::create('stock_in_details', function (Blueprint $table) {
            $table->id('stockin_detail_id');
            $table->foreignId('stockin_id')
                ->constrained('stock_ins', 'stockin_id')
                ->onDelete('cascade');
            $table->foreignId('book_id')
                ->constrained('books', 'book_id')
                ->onDelete('cascade');
            $table->decimal('price_per_unit', 8, 2);
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('new');
            $table->text('remarks')->nullable();
            $table->integer('received_quantity')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_details');
    }
};
