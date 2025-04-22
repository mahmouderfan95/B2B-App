<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained("clients")->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained("wallets")->cascadeOnDelete();
            $table->string("type")->default(1);
            $table->unsignedBigInteger("amount")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transaction_histories');
    }
};
