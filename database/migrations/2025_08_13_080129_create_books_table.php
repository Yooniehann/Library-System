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
            $table->id('book_id');
            $table->foreignId('author_id')
                ->constrained('authors', 'author_id')
                ->onDelete('cascade');
            $table->foreignId('publisher_id')
                ->constrained('publishers', 'publisher_id')
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->constrained('categories', 'category_id')
                ->onDelete('cascade');
            $table->string('title', 255);
            $table->string('isbn', 20)->unique();
            $table->year('publication_year');
            $table->string('language', 50)->default('English');
            $table->integer('pages')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->decimal('pricing', 8, 2);
            $table->timestamps();
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
