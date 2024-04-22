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
            $table->time('period_of_time')->default('04:00:00')->after('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircraft_location_pilots', function (Blueprint $table) {
            $table->dropColumn(['period_of_time']);
        });
    }
};
