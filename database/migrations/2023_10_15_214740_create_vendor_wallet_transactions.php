<?php

use App\Enums\VendorWallet;
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
        Schema::create('vendor_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_wallet_id')->constrained('vendor_wallets')->cascadeOnDelete();
            $table->unsignedBigInteger('amount')->default(0);
            $table->enum('operation_type', VendorWallet::getTypes());
            $table->unsignedBigInteger('admin_id')->nullable();
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
        Schema::dropIfExists('vendor_wallet_transactions');
    }
};
