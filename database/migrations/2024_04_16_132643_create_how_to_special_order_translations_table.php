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
        Schema::create('how_to_special_order_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('how_to_sp_order_id')->constrained('how_to_special_orders')->cascadeOnDelete();
            $table->foreignId('language_id')->nullable()->constrained("languages")->cascadeOnDelete();
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('how_to_special_order_translations');
    }
};
