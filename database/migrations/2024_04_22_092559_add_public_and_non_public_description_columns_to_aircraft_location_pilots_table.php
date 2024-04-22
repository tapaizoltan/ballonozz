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
        Schema::table('aircraft_location_pilots', function (Blueprint $table) {
            $table->longText('public_description')->nullable()->after('status');
            $table->longText('non_public_description')->nullable()->after('public_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircraft_location_pilots', function (Blueprint $table) {
            $table->dropColumn(['public_description']);
            $table->dropColumn(['non_public_description']);
        });
    }
};
