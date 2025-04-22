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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained("categories")->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained("types")->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained("units")->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained("vendors")->nullOnDelete();
            $table->foreignId('certificate_id')->nullable()->constrained("certificates")->nullOnDelete();
            $table->foreignId('quality_id')->nullable()->constrained("qualities")->cascadeOnDelete();
            $table->string('image')->default('images/no-image.png');
            $table->double('price')->nullable();
            $table->double('price_from')->nullable();
            $table->double('price_to')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_visible')->default(0);
            $table->enum('status',['pending','refused','accepted'])->default('pending');
            $table->double('weight')->nullable();
            $table->double('length')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->integer('sort_order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
