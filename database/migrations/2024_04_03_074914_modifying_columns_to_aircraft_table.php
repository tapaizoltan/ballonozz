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
        Schema::table('aircraft', function (Blueprint $table) {
            $table->dropColumn(['unlimited']);
            $table->dropColumn(['vip']);
            $table->dropColumn(['private']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircraft', function (Blueprint $table) {
            $table->boolean('unlimited')->default(false)->after('payload_capacity');
            $table->boolean('vip')->default(false)->after('unlimited');
            $table->boolean('private')->default(false)->after('vip');
        });
    }
};
