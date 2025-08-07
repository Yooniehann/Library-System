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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id'); // Primary key
            $table->unsignedBigInteger('author_id'); // Foreign key to authors
            $table->unsignedBigInteger('publisher_id'); // Foreign key to publishers
            $table->unsignedBigInteger('category_id'); // Foreign key to categories
            $table->string('title');
            $table->string('isbn')->unique();
            $table->integer('publication_year');
            $table->text('description')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('author_id')
                ->references('author_id')
                ->on('authors')
                ->onDelete('cascade'); // or 'restrict'/'set null' as per your needs

            $table->foreign('publisher_id')
                ->references('publisher_id')
                ->on('publishers')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
