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
            //
            $table->foreignId('special_order_id')->after('id')->constrained("special_orders")->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_order_products', function (Blueprint $table) {
            //
            $table->dropColumn('special_order_id');
        });
    }
};
