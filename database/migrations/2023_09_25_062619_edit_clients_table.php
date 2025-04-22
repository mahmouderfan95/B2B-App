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
        Schema::table('clients', function (Blueprint $table) {
            //

            $table->string('another_phone')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('phone')->nullable()->change();


            $table->dropUnique('clients_phone_unique');
            $table->dropUnique('clients_another_phone_unique');
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
