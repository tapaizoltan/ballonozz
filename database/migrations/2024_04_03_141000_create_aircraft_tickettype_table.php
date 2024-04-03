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
        Schema::create('aircraft_tickettype', function (Blueprint $table) {
            $table->integer('aircraft_id')->unsigned()->nullable();
            $table->foreign('aircraft_id')->references('id')->on('aircraft')->onDelete('cascade');
            $table->integer('tickettype_id')->unsigned()->nullable();
            $table->foreign('tickettype_id')->references('id')->on('tickettypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_tickettype');
    }
};
