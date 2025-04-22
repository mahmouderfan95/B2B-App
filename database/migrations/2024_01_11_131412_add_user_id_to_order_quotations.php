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
        Schema::table('order_quotations', function (Blueprint $table) {
            $table->foreignId('client_id')
            ->after('order_id')
            ->constrained('clients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_quotations', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
};
