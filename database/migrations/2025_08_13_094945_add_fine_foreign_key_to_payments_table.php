<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('fine_id')
                ->nullable()
                ->constrained('fines', 'fine_id')
                ->onDelete('cascade')
                ->after('user_id'); 
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['fine_id']);
            $table->dropColumn('fine_id');
        });
    }
};
