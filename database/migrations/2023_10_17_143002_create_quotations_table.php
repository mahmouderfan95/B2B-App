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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained("orders")->cascadeOnDelete();
            $table->foreignId('order_product_id')->constrained("order_products")->cascadeOnDelete();
            $table->double("quotation_price");
            $table->dateTime("expect_date_from");
            $table->dateTime("expect_date_to");
            $table->enum('status',['pending','refused','accepted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
