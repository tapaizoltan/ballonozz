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
        Schema::create('tickettype_region', function (Blueprint $table) {
            $table->integer('tickettype_id')->unsigned()->nullable();
            $table->foreign('tickettype_id')->references('id')->on('tickettypes')->onDelete('cascade');
            $table->integer('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickettype_region');
    }
};
