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
        Schema::create('shipping_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_method_id')->nullable()->constrained("shipping_methods")->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained("orders")->cascadeOnDelete();
            $table->double('price');
            $table->enum('status',['pending','refused','accepted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_offers');
    }
};
