<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_in_details', function (Blueprint $table) {
            // First, make sure the book_id column exists and has data
            if (!Schema::hasColumn('stock_in_details', 'book_id')) {
                $table->foreignId('book_id')->after('stockin_id');
            }

            // Add the foreign key constraint
            $table->foreign('book_id')
                  ->references('book_id')
                  ->on('books')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('stock_in_details', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
        });
    }
};
