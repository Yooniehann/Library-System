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
        Schema::create('membership_types', function (Blueprint $table) {
            $table->id('membership_type_id');
            $table->string('type_name', 50);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('max_books_allowed');
            $table->date('start_date');
            $table->date('expiry_date');
            $table->decimal('membership_monthly_fee', 8, 2);
            $table->decimal('membership_annual_fee', 8, 2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_types');
    }
};
