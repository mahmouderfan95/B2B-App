<?php

use App\Enums\ShippingWallet;
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
        Schema::create('shipping_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_wallet_id')->constrained("shipping_wallets")->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained("users")->cascadeOnDelete();
            $table->unsignedBigInteger('amount')->default(0);
            $table->enum('operation_type', ShippingWallet::getTypes());
            $table->string('receipt_url')->nullable();
            $table->string('reference')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_wallet_transactions');
    }
};
