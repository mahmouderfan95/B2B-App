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
        Schema::table('terms_and_conditions_translations', function (Blueprint $table) {
            $table->longText('term_and_condition')->nullable()->change();
        });
        Schema::table('privacy_policy_translations', function (Blueprint $table) {
            $table->longText('policy')->nullable()->change();
        });
        Schema::table('about_us_translations', function (Blueprint $table) {
            $table->longText('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
