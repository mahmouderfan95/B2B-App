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
            //
            $table->foreignId('bank_id')->nullable()->after('id')->constrained("banks")->cascadeOnDelete();
            $table->string('phone')->after('name');
            $table->string('another_phone')->after('phone');
            $table->string('email')->after('another_phone');
            $table->string('website')->nullable()->after('email');
            $table->string('description')->after('website');
            $table->string('commercial_registration_number')->after('description');
            $table->string('image_commercial')->after('commercial_registration_number');
            $table->string('image_iban')->after('image_commercial');
            $table->string('image_mark')->after('image_iban');
            $table->string('image_tax')->after('image_mark');
            $table->dateTime('expire_date_commercial_registration')->after('image_tax');
            $table->string('password')->after('expire_date_commercial_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
            $table->dropColumn('bank_id');
            $table->dropColumn('phone');
            $table->dropColumn('another_phone');
            $table->dropColumn('email');
            $table->dropColumn('website');
            $table->dropColumn('description');
            $table->dropColumn('commercial_registration_number');
            $table->dropColumn('image_commercial');
            $table->dropColumn('image_iban');
            $table->dropColumn('image_mark');
            $table->dropColumn('image_tax');
            $table->dropColumn('expire_date_commercial_registration');
            $table->dropColumn('password');
        });
    }
};
