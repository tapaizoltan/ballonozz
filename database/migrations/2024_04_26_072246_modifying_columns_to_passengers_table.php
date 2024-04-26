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
        Schema::table('passengers', function (Blueprint $table) {
            $table->string('firstname')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('id_card_number')->nullable()->change();
            $table->string('body_weight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->string('firstname')->change();
            $table->date('date_of_birth')->change();
            $table->string('id_card_number')->change();
            $table->string('body_weight')->change();
        });
    }
};
