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
        Schema::table('client_addresses', function (Blueprint $table) {
            //
            $table->string('first_name')->nullable()->after('phone');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('zip_code')->nullable()->after('last_name');
            $table->string('Port_details')->nullable()->after('zip_code');
            $table->unsignedBigInteger('country_id')->after('Port_details');
            $table->string('shipping_method')->nullable()->after('country_id');
            $table->foreignId('city_id')->nullable()->nullOnDelete()->change();

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
