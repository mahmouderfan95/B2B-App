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
        Schema::create('order_quotation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_quotation_id')->constrained('order_quotations')->cascadeOnDelete();
            $table->foreignId('special_order_id')->constrained('special_orders')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->enum('status',['pending','refused','accepted'])->default('pending');
            $table->double("quotation_price");
            $table->string('sender_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_quotation_histories');
    }
};
