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
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['parcel_number']);
            $table->string('coordinates')->nullable()->after('address_number');
            $table->string('online_map_link')->nullable()->after('coordinates');
            $table->string('image_path')->nullable()->after('online_map_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['coordinates']);
            $table->dropColumn(['online_map_link']);
            $table->dropColumn(['image_path']);
            $table->string('parcel_number')->nullable()->comment('helyrajzi szám')->after('address_number');
        });
    }
};
