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
        Schema::table('special_order_products', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')
            ->references('id')
            ->on('special_orders')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_order_products', function (Blueprint $table) {
        });
    }
};
