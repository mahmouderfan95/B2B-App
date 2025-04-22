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
            $table->string("sender_type");
            $table->foreignId('order_id')->nullable()->constrained("special_orders")->cascadeOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_quotations', function (Blueprint $table) {
            $table->dropColumn('sender_type');
        });
    }
};
