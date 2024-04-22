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
            $table->dropColumn(['period_of_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircraft_location_pilots', function (Blueprint $table) {
            $table->integer('period_of_time')->default(4)->after('time');
        });
    }
};
