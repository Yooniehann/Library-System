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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');
            // $table->foreignId('fine_id')
            //     ->nullable()
            //     ->constrained('fines', 'fine_id')
            //     ->onDelete('cascade');
            $table->foreignId('membership_type_id')
                ->nullable()
                ->constrained('membership_types', 'membership_type_id')
                ->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['fine', 'membership_fee']);
            $table->enum('payment_method', ['cash', 'card', 'online']);
            $table->dateTime('payment_date')->default(now());
            $table->string('transaction_id', 100)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['completed', 'pending', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
