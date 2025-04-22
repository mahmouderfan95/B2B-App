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
        Schema::table('special_orders', function (Blueprint $table) {
            //
            $table->foreignId('shipping_special_offer_id')->nullable()->after('vendor_id')->constrained("shipping_special_offers")->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_orders', function (Blueprint $table) {
            //
            $table->dropColumn('shipping_special_offer_id');
        });
    }
};
