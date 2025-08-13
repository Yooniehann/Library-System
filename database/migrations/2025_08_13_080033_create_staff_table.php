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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->string('fullname', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('position', 50);
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
