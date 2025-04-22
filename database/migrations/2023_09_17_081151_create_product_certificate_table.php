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
        Schema::create('product_certificate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained("certificates")->cascadeOnDelete();
            $table->foreignId('product_id')->constrained("products")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_certificate');
    }
};
