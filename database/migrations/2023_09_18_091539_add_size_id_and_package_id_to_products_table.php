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
        Schema::table('products', function (Blueprint $table) {
            //
            $table->foreignId('package_id')->nullable()->after('vendor_id')->constrained("packages")->nullOnDelete();
            $table->foreignId('size_id')->nullable()->after('package_id')->constrained("sizes")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn('package_id');
            $table->dropColumn('size_id');
        });
    }
};
