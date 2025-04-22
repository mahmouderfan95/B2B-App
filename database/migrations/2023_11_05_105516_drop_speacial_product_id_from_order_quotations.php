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
        Schema::table('order_quotations', function (Blueprint $table) {
            //
            $table->dropForeign('order_quotations_special_order_product_id_foreign');
            $table->dropColumn('special_order_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_quotations', function (Blueprint $table) {
            //
            $table->foreignId('special_order_product_id')->constrained("special_order_products")->cascadeOnDelete();
        });
    }
};
