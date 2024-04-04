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
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['vip']);
            $table->dropColumn(['private']);
            $table->dropColumn(['aircraft_type']);
            $table->integer('tickettype_id')->nullable()->after('children');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['tickettype_id']);
            $table->boolean('vip')->default(false)->after('children');
            $table->boolean('private')->default(false)->after('vip');
            $table->integer('aircraft_type')->nullable()->after('private');
        });
    }
};
