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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string("web_site")->nullable();
            $table->string('vendor_name')->nullable();
            $table->boolean('accept_terms')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropIfExists("web_site");
            $table->dropIfExists('vendor_name');
            $table->dropIfExists('accept_terms');
        });
    }
};
