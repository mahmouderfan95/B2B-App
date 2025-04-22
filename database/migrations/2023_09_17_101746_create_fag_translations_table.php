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
        Schema::create('fag_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fag_id')->nullable()->constrained("fags")->cascadeOnDelete();
            $table->foreignId('language_id')->nullable()->constrained("languages")->cascadeOnDelete();
            $table->text('question');
            $table->longText('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fag_translations');
    }
};
