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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->nullable()->constrained("transactions")->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained("vendors")->cascadeOnDelete();
            $table->string("payment_method")->default('cod');
            $table->string("shipping_method")->default('free');
            $table->dateTime("date");
            $table->string('status');
            $table->string("delivery_type");
            $table->double("total")->nullable();
            $table->double("sub_total")->nullable();
            $table->double("vat")->nullable();
            $table->double("tax")->nullable();
            $table->string('code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
