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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id('inventory_id');
            $table->foreignId('book_id')
                ->constrained('books', 'book_id')
                ->onDelete('cascade');
            $table->foreignId('stockin_detail_id')
                ->constrained('stock_in_details', 'stockin_detail_id')
                ->onDelete('cascade');
            $table->string('copy_number', 20)->unique();
            $table->enum('condition', ['new', 'good', 'fair', 'poor', 'damaged'])->default('good');
            $table->date('acquisition_date')->default(now());
            $table->enum('status', ['available', 'borrowed', 'reserved', 'lost'])->default('available');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
