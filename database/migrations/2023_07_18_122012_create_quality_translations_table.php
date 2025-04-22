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
        Schema::create('quality_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_id')->nullable()->constrained("qualities")->cascadeOnDelete();
            $table->foreignId('language_id')->nullable()->constrained("languages")->cascadeOnDelete();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_translations');
    }
};
