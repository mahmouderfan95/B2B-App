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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('rate')->default(1);
            $table->text('comment')->nullable();
            $table->foreignId('client_id')->nullable()->constrained("clients")->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained("products")->cascadeOnDelete();
            $table->enum('status',['pending','refused','accepted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
