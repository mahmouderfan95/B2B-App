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
        Schema::create('clients_verify', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('code');
            $table->timestamps();

            Schema::table('clients', function (Blueprint $table) {
                $table->boolean('is_email_verified')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_verify');
    }
};
