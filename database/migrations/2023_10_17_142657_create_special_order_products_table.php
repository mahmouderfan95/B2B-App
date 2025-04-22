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
        Schema::create('special_order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained("orders")->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained("products")->cascadeOnDelete();
            $table->double("total");
            $table->double("quantity");
            $table->double("unit_price");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_order_products');
    }
};
