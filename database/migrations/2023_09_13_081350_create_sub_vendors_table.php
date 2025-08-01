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
        Schema::create('sub_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->nullable()->constrained("vendors")->cascadeOnDelete();
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->string('password', 64);
            $table->string('phone', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_vendors');
    }
};
