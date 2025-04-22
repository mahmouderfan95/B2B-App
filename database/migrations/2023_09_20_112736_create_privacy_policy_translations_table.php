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
        Schema::create('privacy_policy_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privacy_policy_id')->nullable()->constrained("privacy_policies")->cascadeOnDelete();
            $table->foreignId('language_id')->nullable()->constrained("languages")->cascadeOnDelete();
            $table->longText('policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy_policy_translations');
    }
};
