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
        Schema::table('tickettypes', function (Blueprint $table) {
            $table->dropColumn(['source']);
            $table->dropColumn(['name_stored_at_source']);
            $table->dropColumn(['adult']);
            $table->dropColumn(['children']);
            $table->dropColumn(['vip']);
            $table->dropColumn(['private']);

            $table->string('color')->nullable()->after('description');
            $table->integer('aircrafttype')->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickettypes', function (Blueprint $table) {
            $table->dropColumn(['color']);
            $table->dropColumn(['aircrafttype']);

            $table->string('source')->after('description');
            $table->string('name_stored_at_source')->after('source');
            $table->integer('adult')->after('name_stored_at_source');
            $table->integer('children')->after('adult');
            $table->boolean('vip')->default(false)->after('children');
            $table->boolean('private')->default(false)->after('vip');
        });
    }
};
