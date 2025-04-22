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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string("logo")->nullable();
            $table->string("email")->unique();
            $table->string("integration_key")->nullable();
            $table->double('delivery_fees', 12, 2)->nullable();
            $table->unsignedInteger('delivery_fees_covered_kilos')->nullable();
            $table->double('additional_kilo_price', 9, 2)->nullable();
            $table->double('cod_collect_fees', 9, 2)->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->tinyInteger('banned')->default(0);
            $table->string('password', 64);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
