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
        Schema::table('special_orders', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_orders', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
        });
    }
};
