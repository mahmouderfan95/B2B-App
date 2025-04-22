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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained("clients")->cascadeOnDelete();
            $table->dateTime("date");
            $table->string('status');
            $table->double("total")->nullable();
            $table->double("sub_total")->nullable();
            $table->double("total_vat")->nullable();
            $table->double("total_tax")->nullable();
            $table->string('code')->nullable();
            $table->integer("products_count");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
